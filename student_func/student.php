<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_permission'] != 'student')) {
    // 不存在session用户id，退出
    echo "<script>alert('请先登录'); window.location.href=\"../login.html\";</script>";
    exit;
}
include '../header.php';
?>

<!--主体-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-sidebar-left  sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="./student.php?func=topic" method="GET" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "topic") {
                                                                        echo "class=active";
                                                                    } ?>><i class="glyphicon glyphicon-list-alt"> 论文选题</i><span class="sr-only">(current)</span></a></li>


                <li><a href="./student.php?func=task_book" method="GET" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "task_book") {
                                                                            echo "class=active";
                                                                        } ?>>
                        <i class="glyphicon glyphicon-file"> 任务书</i><span class="sr-only">(current)</span></a></li>
                <br />

                <li><a href="./student.php?func=first_report" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "first_report") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-file"> 开题报告</i><span class="sr-only">(current)</span></a></li>


                <li><a href="./student.php?func=midterm_report" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "midterm_report") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-file"> 中期报告</i><span class="sr-only">(current)</span></a></li>

                <li><a href="./student.php?func=first_paper" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "first_paper") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-file"> 论文初稿</i><span class="sr-only">(current)</span></a></li>
                <br />

                <li><a href="./student.php?func=delay_reply"<?php if (isset($_GET["func"]) && ($_GET["func"]) == "delay_reply") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-warning-sign"> 延期答辩
                        </i><span class="sr-only">(current)</span></a></li>

                <li><a href="./student.php?func=answer_information"<?php if (isset($_GET["func"]) && ($_GET["func"]) == "answer_information") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-list-alt"> 答辩信息
                        </i><span class="sr-only">(current)</span></a></li>

                <li><a href="./student.php?func=second_reply" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "second_reply") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-warning-sign"> 二次答辩</i>
                        <span class="sr-only">(current)</span></a></li>

                <li><a href="./student.php?func=final_draft" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "final_draft") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-file"> 论文终稿</i> <span class="sr-only">(current)</span></a></li>
                <br />

                <li><a href="./student.php?func=inquiry_result" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "inquiry_result") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-search"> 成绩查询 </i><span class="sr-only">(current)</span></a></li>


                <li><a href="./student.php?func=excellent_paper" <?php if (isset($_GET["func"]) && ($_GET["func"]) == "excellent_paper") {
                                                                    echo "class=active";
                                                                } ?>><i class="glyphicon glyphicon-thumbs-up"> 优秀论文
                        </i><span class="sr-only">(current)</span></a></li>
            </ul>
        </div>
        <div class="col-sm-sidebar-right col-sm-offset-right main">
            <div class="centeredalter">
                <?php
                if (isset($_GET["func"])) {
                    $result = $_GET["func"];
                    switch ($result) {
                        case "topic":
                            if (isset($_GET["id"])) {
                                include "../tutor_func/t_topic_detail.php";
                            } else {
                                include "stu_topic.php";
                            }
                            break;
                        case "task_book":
                            include "stu_task_book_detail.php";
                            break;
                        case "first_report":
                            if (isset($_GET["id"])) {
                                include "stu_report_suggestion_detail.php";
                            } elseif (isset($_GET["fid"])) {
                                include "stu_first_report_detail.php";
                            } else {
                                include "stu_first_report.php";
                            }

                            break;
                        case "midterm_report":
                            if (isset($_GET["id"])) {
                                include "stu_midterm_instructions_detail.php";
                            } elseif (isset($_GET["fid"])) {
                                include "stu_midterm_report_detail.php";
                            } else {
                                include "stu_midterm_report.php";
                            }
                            break;
                        case "first_paper":
                            if (isset($_GET["id"])) {
                                include "stu_first_paper_suggestion_detail.php";
                            } elseif (isset($_GET["fid"])) {
                                include "stu_first_paper_detail.php";
                            } else {
                                include "stu_first_paper.php";
                            }
                            break;
                        case "answer_information":
                            include "stu_answer_information.php";
                            break;
                        case "delay_reply":
                            include "stu_delay_reply.php";
                            break;
                        case "second_reply":
                        case "reply_record":
                        case "final_draft":
                        case "inquiry_result":
                        case "excellent_paper":
                    }
                } else {
                    echo "欢迎";
                }
                ?>
            </div>
        </div>
    </div>
</div>