<?php
include "../link.php";
$get = $_GET['func'];
switch ($get) {
    case "topic":
        $sql = "UPDATE `t_func_control` SET `topic` = 1 WHERE `id` = 1";
        mysqli_query($link, $sql);
        echo "<script>alert('开启老师选题流程成功！'); history.go(-1);</script>";
        break;
    case "first_report":
        $sql = "UPDATE `t_func_control` SET `first_report` = 1 WHERE `id` = 1";
        mysqli_query($link, $sql);
        echo "<script>alert('开启老师开题流程成功！'); history.go(-1);</script>";
        break;
    case "first_paper":
        $sql = "UPDATE `t_func_control` SET `first_paper` = 1 WHERE `id` = 1";
        mysqli_query($link, $sql);
        echo "<script>alert('开启老师论文初稿流程成功！'); history.go(-1);</script>";
        break;
    case "first_reply":
        $sql= "UPDATE `t_func_control` SET `first_reply` = 1 WHERE `id` = 1";
        mysqli_query($link, $sql);
        echo "<script>alert('开启老师一次答辩流程成功！');history.go(-1);</script>";
        break;
    case "first_reply_grade":
        $sql= "UPDATE `t_func_control` SET `first_reply_grade` = 1 WHERE `id` = 1";
        mysqli_query($link, $sql);
        echo "<script>alert('开启老师一次答辩评分流程成功！');history.go(-1);</script>";
        break;
    case "second_reply_grade":
        $sql= "UPDATE `t_func_control` SET `second_reply_grade` = 1 WHERE `id` = 1";
        mysqli_query($link, $sql);
        echo "<script>alert('开启老师二次答辩评分流程成功！');history.go(-1);</script>";
        break;
}
