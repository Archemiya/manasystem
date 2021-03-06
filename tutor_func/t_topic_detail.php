<?php
include "../link.php";
if (isset($_GET["id"])) {
    $get = $_GET["id"];
}
$sql = "SELECT * FROM `topic`WHERE `id` = {$get} ORDER BY `id`  ASC";
$result = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body>
    <div class="table-responsive">
        <table data-toggle="table" data-toolbar="#toolbar">
            <tbody>
                <?php
                $row = mysqli_fetch_array($result, MYSQLI_BOTH);
                echo "<br/>";
                echo "<tr>";
                echo "<td class='col-xs-2'>课题名称</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['name']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>课题类型</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_type']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>题目性质</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_nature']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>题目来源</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_source']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>题目预计难易程度</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_difficulty']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>题目简介</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['introduction']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>毕业设计(论文)要求</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_request']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>主要参考资料</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_reference']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>其他指导老师【可选】</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_otherteacher']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>课题选择模式</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_chosemode']);
                echo " </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='col-xs-2'>课题适用专业</td>";
                echo "<td class='col-xs-10'>";
                echo nl2br($row['topic_application']);
                echo " </td>";
                echo "</tr>";

                ?>
            </tbody>
        </table>

    </div>
    <br />
    <button type="button" class="btn btn-primary" onclick="JavaScript:history.go(-1)">返回</button>
</body>

</html>