<?php
define("ROW_PER_PAGE",10);
require_once("dbcontrollerPDO.php");
$db_handle = new DBController();
?>
<html>
    <head>
        <style>
            body{width:615px;font-family:arial;letter-spacing:1px;line-height:20px;}
            .tbl-qa{width: 100%;font-size:0.9em;background-color: #f5f5f5;}
            .tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
            .tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;vertical-align:top;}
            .button_link {color:#FFF;text-decoration:none; background-color:#428a8e;padding:10px;}
            #keyword{border: #CCC 1px solid; border-radius: 4px; padding: 7px;background:url("demo-search-icon.png") no-repeat center right 7px;}
            .btn-page{margin-right:10px;padding:5px 10px; border: #CCC 1px solid; background:#FFF; border-radius:4px;cursor:pointer;}
            .btn-page:hover{background:#F0F0F0;}
            .btn-page.current{background:#F0F0F0;}
        </style>
    </head>
    <body>
        <?php	
        $search_keyword = '';
        if(!empty($_POST['search']['keyword'])) {
            $search_keyword = $_POST['search']['keyword'];
        }
        //$sql = 'SELECT * FROM posts WHERE post_title LIKE :keyword OR description LIKE :keyword OR post_at LIKE :keyword ORDER BY id DESC ';
        $sql = "SELECT DAFAC_DAFAC_SN, IDP_ID, Fname, Lname, Mname, CONCAT(Lname, ', ', Fname, ' ', Mname) AS IDPName, Gender, Age, COALESCE(MIN(j.INTAKE_ANSWERS_ID), 0) AS intake_answersID FROM `idp` i  LEFT JOIN intake_answers j on i.IDP_ID = j.IDP_IDP_ID WHERE Lname LIKE :keyword OR Fname LIKE :keyword OR Mname LIKE :keyword  OR Fname LIKE :keyword OR IDP_ID LIKE :keyword GROUP BY i.IDP_ID, IDPName  ORDER BY IDPName ASC";

        /* Pagination Code starts */
        $per_page_html = '';
        $page = 1;
        $start=0;
        if(!empty($_POST["page"])) {
            $page = $_POST["page"];
            $start=($page-1) * ROW_PER_PAGE;
        }
        $limit=" limit " . $start . "," . ROW_PER_PAGE;
        $db_handle->prepareStatement($sql);
        $db_handle->bindVar(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR, 0);
        $db_handle->runFetch();

        $row_count = $db_handle->getFetchCount();
        echo($row_count."----------ROW COUNT");
        if(!empty($row_count)){
            $per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
            $page_count=ceil($row_count/ROW_PER_PAGE);
            if($page_count>1) {
                for($i=1;$i<=$page_count;$i++){
                    if($i==$page){
                        $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
                    } else {
                        $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
                    }
                }
            }
            $per_page_html .= "</div>";
        }

        $query = $sql.$limit;
        $db_handle->prepareStatement($query);
        $db_handle->bindVar(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR, 0);
        $result = $db_handle->runFetch();
        ?>
        <form name='frmSearch' action='' method='post'>
            <div style='text-align:right;margin:20px 0px;'><input type='text' name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'></div>
            <table class='tbl-qa'>
                <thead>
                    <tr>
                        <th align="left"><b>Family ID</b></th>
                        <th align="left"><b>IDP ID</b></th>
                        <th align="left"><b>Name</b></th>
                        <th align="left"><b>Gender</b></th>
                        <th align="left"><b>Age</b></th>
                        <th align="left"><b>Action</b></th>
                    </tr>
                </thead>
                <tbody id='table-body'>
                    <?php
                    if(!empty($result)) { 
                        foreach($result as $row) {
                    ?>
                    <tr class='table-row'>
                        <td><?php echo $row['DAFAC_DAFAC_SN']; ?></td>
                        <td><?php echo $row['IDP_ID']; ?></td>
                        <td><?php echo $row['IDPName']; ?></td>
                        <td><?php echo $row['Gender']; ?></td>
                        <td><?php echo $row['Age']; ?></td>
                        <td><?php echo '
                        <button class="btn btn-info btn-sm btn-fill" id="'.$row['IDP_ID'].'" onClick ="load_modal(this.id)"><i class="pe-7s-info"></i> View</button>
                        <a class="btn btn-warning btn-sm btn-fill" href="deletecswd.php?id="'.$row['IDP_ID'].'"><i class="pe-7s-delete-user"></i> Update </a>'
                        ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php echo $per_page_html; ?>
        </form>
    </body>
</html>

