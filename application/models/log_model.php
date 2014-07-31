<?php

/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 7/29/14
 * Time: 5:16 PM
 */
class Log_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbLog;
        $this->tableMember = $this->Constant_model->tbMember;
    }

    private $tableName = "";
    private $tableMember = "";

    function logList($id = 0, $orderBy = "", $limit = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id DESC";
        $limit = $limit ? " LIMIT $limit" : " LIMIT 50";
        $sql = "
            SELECT
              *
            FROM $this->tableName
            WHERE 1
            $strAnd
            $strOrder
            $limit
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function feedList($max_feed = 0)
    {
        $strAND = $max_feed ? " AND a.id = $max_feed" : "";
        $sql = "
            SELECT
              a.*,
              CONCAT(b.prefix,
              b.firstname, ' ',
              b.lastname) AS name
            FROM $this->tableName a
            INNER JOIN $this->tableMember b
            ON (a.member_id = b.id)
            WHERE 1
            $strAND
            ORDER BY a.id DESC
            LIMIT 50
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return null;
        }
    }

    function logAdd($title, $table, $line, $data = array())
    {
        //json_encode($data) //converts an array to JSON string
        //json_decode($jsonString) //converts json string to php array
        $memberId = @$this->session->userdata['id'];
        $username = @$this->session->userdata['username'];
        if (is_array($data)) {
            $data["line"] = $line;
            $data["table"] = $table;
        } else {
            $data = array(
                'id' => $memberId,
                'username' => $username,
                'line' => $line,
                'table' => $table,
            );
        }
        $description = json_encode($data);
//        $title = $this->createTitleLog($type, $table, $line);
        $data = array(
            'title' => $title,
            'description' => $description,
            'member_id' => intval($memberId),
            'create_datetime' => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->tableName, $data);
        return $id = $this->db->insert_id($this->tableName);
    }

    function createTitleLog($type, $table)
    {
        return "$type;$table";
    }

    function deleteLog()
    {
        $sql = "
          DELETE FROM $this->tableName WHERE create_datetime < DATE_SUB(NOW(), INTERVAL 1 MONTH);
        ";
        $query = $this->db->query($sql);
        $this->logAdd("check delete log", 'log', __LINE__, $query);
        return true;
    }

    /**
     * Create the data output array for the DataTables rows
     *
     * @param  array $columns Column information array
     * @param  array $data    Data from the SQL get
     * @return array          Formatted data in a row based format
     */
    function data_output($columns, $data)
    {
        $out = array();

        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];
                }
            }

            $out[] = $row;
        }

        return $out;
    }


    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @return string SQL limit clause
     */
    function limit($request)
    {
        $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }

        return $limit;
    }


    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @return string SQL order by clause
     */
    function order($request, $columns)
    {
        $order = '';

        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = $this->pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';

                    $orderBy[] = ' ' . $column['db'] . ' ' . $dir;
                }
            }
            $order = 'ORDER BY ' . implode(', ', $orderBy);
            //$order = 'ORDER BY a.id DESC';
        }

        return $order;
    }


    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @param  array $bindings Array of values for PDO bindings, used in the
     *    sql_exec() function
     * @return string SQL where clause
     */
    function filter($request, $columns, &$bindings)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = $this->pluck($columns, 'dt');

        if (isset($request['search']) && $request['search']['value']) {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    $binding = $this->bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $globalSearch[] = " " . $column['db'] . " LIKE " . $binding;
                }
            }
        }

        // Individual column filtering
        for ($i = 0, $ien = count(@$request['columns']); $i < $ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$columnIdx];

            $str = $requestColumn['search']['value'];

            if ($requestColumn['searchable'] == 'true' &&
                $str
            ) {
                $binding = $this->bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                $columnSearch[] = " " . $column['db'] . " LIKE " . $binding;
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }
/*
        $arrOtherSearch = array();
        @$request['workorder'] ? $arrOtherSearch[] = " a.workorder LIKE '%" . trim($request['workorder']) . "%'" : null;
        @$request['po_no'] ? $arrOtherSearch[] = " a.po_no LIKE '%" . trim($request['po_no']) . "%'" : null;
        @$request['invoice_no'] ? $arrOtherSearch[] = " a.invoice_no LIKE '%" . trim($request['invoice_no']) . "%'" : null;
        @$request['hawb_hbl'] ? $arrOtherSearch[] = " a.hawb_hbl LIKE '%" . trim($request['hawb_hbl']) . "%'" : null;
        @$request['pre_alert'] ? $arrOtherSearch[] = " a.pre_alert = '" .
            $this->Helper_model->convertDate(trim($request['pre_alert'])) . "'" : null;
        @$request['pending'] ? $arrOtherSearch[] = " a.pending = '" . ($request['pending']) . "'" : null;
        @$request['company_id'] ? $arrOtherSearch[] = " a.company_id = '" . ($request['company_id']) . "'" : null;
        @$request['shipment_type'] ? $arrOtherSearch[] = " a.shipment_type = '" . ($request['shipment_type']) . "'" : null;
        @$request['transport_type'] ? $arrOtherSearch[] = " a.transport_type = '" . ($request['transport_type']) . "'" : null;
        @$request['pod_id'] ? $arrOtherSearch[] = " a.pod_id = '" . ($request['pod_id']) . "'" : null;
        //@$request['shipment_status'] ? $arrOtherSearch[] = " a.shipment_status = '" . ($request['shipment_status']) . "'" : null;
        @$request['branch'] ? $arrOtherSearch[] = " a.branch = '" . ($request['branch']) . "'" : null;

        switch (@$request['shipment_status']) {
            case '1':
                $arrOtherSearch[] = " a.`shipment_type`='Import' AND a.status_receive_doc<>'0000-00-00'
                AND a.status_prepare_permit='0000-00-00' AND a.status_customs_clearance='0000-00-00'
                AND a.status_store_warehouse='0000-00-00' AND a.status_delivered='0000-00-00'
                AND a.status_complete_customs='0000-00-00'";
                break;
            case '2':
                $arrOtherSearch[] = " a.`shipment_type`='Import' AND a.status_prepare_permit<>'0000-00-00'
                 AND a.status_customs_clearance='0000-00-00' AND a.status_store_warehouse='0000-00-00'
                 AND a.status_delivered='0000-00-00' AND a.status_complete_customs='0000-00-00'";
                break;
            case '3':
                $arrOtherSearch[] = " a.`shipment_type`='Import' AND a.status_customs_clearance<>'0000-00-00'
                 AND a.status_store_warehouse='0000-00-00' AND a.status_delivered='0000-00-00'
                 AND a.status_complete_customs='0000-00-00'";
                break;
            case '4':
                $arrOtherSearch[] = " a.`shipment_type`='Import' AND a.status_store_warehouse<>'0000-00-00'
                 AND a.status_delivered='0000-00-00' AND a.status_complete_customs='0000-00-00'";
                break;
            case '5':
                $arrOtherSearch[] = " a.`shipment_type`='Import' AND a.status_delivered<>'0000-00-00'
                AND a.status_complete_customs='0000-00-00'";
                break;
            case '6':
                $arrOtherSearch[] = " a.`shipment_type`='Import' AND a.status_complete_customs<>'0000-00-00'";
                break;
            case '7':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_receive_doc<>'0000-00-00'
                 AND a.status_submit_doc='0000-00-00' AND a.status_store_warehouse='0000-00-00'
                 AND a.status_booking='0000-00-00' AND a.status_prepare_export='0000-00-00'
                 AND a.status_release_shipment='0000-00-00' AND a.pre_alert='0000-00-00'
                 AND a.status_delivered='0000-00-00'";
                break;
            case '8':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_submit_doc<>'0000-00-00'
                 AND a.status_store_warehouse='0000-00-00' AND a.status_booking='0000-00-00'
                 AND a.status_prepare_export='0000-00-00' AND a.status_release_shipment='0000-00-00'
                 AND a.pre_alert='0000-00-00' AND a.status_delivered='0000-00-00'";
                break;
            case '9':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_store_warehouse<>'0000-00-00'
                AND a.status_booking='0000-00-00' AND a.status_prepare_export='0000-00-00'
                AND a.status_release_shipment='0000-00-00' AND a.pre_alert='0000-00-00'
                AND a.status_delivered='0000-00-00'";
                break;
            case '10':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_booking<>'0000-00-00'
				AND a.status_prepare_export='0000-00-00' AND a.status_release_shipment='0000-00-00'
				AND a.pre_alert='0000-00-00'  AND a.status_delivered='0000-00-00'";
                break;
            case '11':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_prepare_export<>'0000-00-00'
                 AND a.status_release_shipment='0000-00-00' AND a.pre_alert='0000-00-00'
                 AND a.status_delivered='0000-00-00'";
                break;
            case '12':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_release_shipment<>'0000-00-00'
                 AND a.pre_alert='0000-00-00' AND a.status_delivered='0000-00-00'";
                break;
            case '13':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.pre_alert<>'0000-00-00'
                AND a.status_delivered='0000-00-00'";
                break;
            case '14':
                $arrOtherSearch[] = " a.`shipment_type`='Export' AND a.status_delivered<>'0000-00-00'";
                break;
        }

        if ($arrOtherSearch) {
            $strOtherSearch = " AND (";
            $strOtherSearch .= implode(' AND ', $arrOtherSearch);
            $strOtherSearch .= ")";
        } else {
            $strOtherSearch = "";
        }
        $where .= " $strOtherSearch";*/
        return $where;
    }

    function get_data($request)
    {

        $webUrl = $this->Constant_model->webUrl();

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $primaryKey = "a.id";
        $columns = array(
            array('db' => 'a.id', 'dt' => 0),
            array('db' => 'a.title', 'dt' => 1),
            array('db' => "CONCAT(b.prefix,
              b.firstname, ' ',
              b.lastname) AS name", 'dt' => 2),
//            array('db' => 'a.description', 'dt' => 3),
            array(
                'db' => 'a.create_datetime',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                        //return date( 'jS M y', strtotime($d));
                        return date('d/m/Y', strtotime($d));
                    }
            ),
            /*array(
                'db' => 'start_date',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    //return date( 'jS M y', strtotime($d));
                    return date('d/m/Y', strtotime($d));
                }
            ),
            array(
                'db' => 'salary',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    return '$' . number_format($d);
                }
            )*/
        );
        $columnsShow = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'title', 'dt' => 1),
            array('db' => 'name', 'dt' => 2),
//            array('db' => 'description', 'dt' => 3),
            array(
                'db' => 'create_datetime',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                        //return date( 'jS M y', strtotime($d));
                        return date('d/m/Y', strtotime($d));
                    }
            ),
        );
        $bindings = array();
        $db = $this->sql_connect($sql_details);

        // Build the SQL query string from the request
        $from = "
            FROM $this->tableName a
            LEFT JOIN $this->tableMember b
            ON (
                a.member_id = b.id
                AND b.publish = 1
            )
        ";
        $limit = $this->limit($request);
        $order = $this->order($request, $columnsShow);
        $where = " WHERE 1 " .
            $this->filter($request, $columnsShow, $bindings);

        // Main query to actually get the data
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $this->pluck($columns, 'db')) . "
            $from
            $where
            $order
            $limit
        ";
        //echo $sql;exit;
        $data = $this->sql_exec($db, $bindings, $sql);

        // Data set length after filtering
        $resFilterLength = $this->sql_exec($db, "SELECT FOUND_ROWS()");
        $recordsFiltered = $resFilterLength[0][0];

        // Total data set length
        $sql = "
            SELECT
              COUNT({$primaryKey})
              $from
              WHERE 1
        ";
        $resTotalLength = $this->sql_exec($db, $sql);
        $recordsTotal = $resTotalLength[0][0];


        $data = $this->data_output($columnsShow, $data);
        /*$newData = $data;
        $urlEdit = $webUrl . "shipment/edit/";
        $urlDelete = $webUrl . "shipment/delete/";
        $permissionUpdate = $this->Module_model->checkModuleByPermission("Shipments", 2);
        $permissionDelete = $this->Module_model->checkModuleByPermission("Shipments", 3);
        foreach ($data as $key => $value) {
            //$newData[$key][0] = $key + 1;
            $idStyle = $data[$key][5];
            $newData[$key][4] = $data[$key][4] == "Import" ?
                '<i class="icon-import">Import</i>' :
                '<i class="icon-export">Export</i>';
            $newData[$key][4] = $newData[$key][4] . '&nbsp;<i class="icon-shipment-status' . $idStyle . '"></i>';
            $strEdit = $permissionUpdate ? '<a href="' . $urlEdit . $data[$key][0] . '"' .
                ' class="btn" rel="tooltip" data-original-title="Edit" title="Edit">' .
                '<i class="icon-edit"></i></a>' : '';
            $strEdit .= $permissionDelete ? '&nbsp;<a href="#messageDeleteData" class="btn" ' .
                ' rel="tooltip" title="Delete"' .
                ' data-original-title="Delete" onclick="urlDelete=\'' . $urlDelete . $data[$key][0] . '\'";' .
                ' role="button" data-toggle="modal"><i class="icon-remove"></i></a>' : '';
            $newData[$key][5] = $strEdit;
        }
        $data = $newData;*/

        /*
         * Output
         */
        return array(
            "draw" => intval(@$request['draw']),
            "recordsTotal" => intval(@$recordsTotal),
            "recordsFiltered" => intval(@$recordsFiltered),
            "data" => $data
        );
    }

    /**
     * Connect to the database
     *
     * @param  array $sql_details SQL server connection details array, with the
     *   properties:
     *     * host - host name
     *     * db   - database name
     *     * user - user name
     *     * pass - user password
     * @return resource Database connection handle
     */
    function sql_connect($sql_details)
    {
        $db = null;
        try {
            $db = @new PDO(
                "mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
                $sql_details['user'],
                $sql_details['pass'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            $this->fatal(
                "An error occurred while connecting to the database. " .
                "The error reported by the server was: " . $e->getMessage()
            );
        }

        return $db;
    }


    /**
     * Execute an SQL query on the database
     *
     * @param  resource $db  Database handler
     * @param  array $bindings Array of PDO binding values from bind() to be
     *   used for safely escaping strings. Note that this can be given as the
     *   SQL query string if no bindings are required.
     * @param  string $sql SQL query to execute.
     * @return array         Result from the query (all rows)
     */
    function sql_exec($db, $bindings, $sql = null)
    {

        // Argument shifting
        if ($sql === null) {
            $sql = $bindings;
        }

        $stmt = $db->prepare($sql);
        //echo $sql;

        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }

        // Execute
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $this->fatal("An SQL error occurred: " . $e->getMessage());
        }

        // Return all
        return $stmt->fetchAll();
    }


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */

    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     */
    function fatal($msg)
    {
        echo json_encode(array(
            "error" => $msg
        ));

        exit(0);
    }

    /**
     * Create a PDO binding key which can be used for escaping variables safely
     * when executing a query with sql_exec()
     *
     * @param  array &$a    Array of bindings
     * @param  *      $val  Value to bind
     * @param  int $type PDO field type
     * @return string       Bound key to be used in the SQL where this parameter
     *   would be used.
     */
    function bind(&$a, $val, $type)
    {
        $key = ':binding_' . count($a);

        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );

        return $key;
    }


    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param  array $a    Array to get data from
     * @param  string $prop Property to read
     * @return array        Array of property values
     */
    function pluck($a, $prop)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }

        return $out;
    }
}