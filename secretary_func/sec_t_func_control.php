<br />
<div class="alert alert-danger" role="alert"><strong>本页面为老师流程控制页面，请谨慎操作</strong></div>
<?php
include "../link.php";
include "sec_query_t_control.php";

$sql_stu_control = "SELECT * from `stu_func_control` where `id` = 1";
$result_stu_control = mysqli_query($link, $sql_stu_control);
$row_stu_control = mysqli_fetch_array($result_stu_control, MYSQLI_BOTH);

date_default_timezone_set('Asia/Shanghai');
$today = date('Y-m-d');
?>

<body>
    <div class="alert alert-info" role="alert">
        <span><strong>开题流程</strong></span>表示导师可以对开题报告进行评分（开启条件：所有学生全部上交开题报告最终稿或超过提交截止日期）<br />
        <span><strong>中期流程</strong></span>只需设置截止时间，之后的开启条件为是否开启开题流程，此流程无需手动打开<br />
        <div>
        </div>
    </div>
    <div class="table-responsive">
        <table data-toggle="table" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th class="col-xs-5 th-title-center">老师流程名称</th>
                    <th class="col-xs-5 th-title-center">状态说明</th>
                    <th class="col-xs-2 th-title-center"> 操作</th>

                </tr>
            </thead>
            <tbody>
                <div id="toolbar">
                </div>
                <tr>
                    <td class="col-xs-5 th-title-center">论文选题</td>

                    <?php
                    if ($row_control['topic'] == 0) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-danger\"> 请根据学校安排准时开启老师论文选题流程！</td>";
                    } else if ($row_control['topic'] == 1) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-info\">已开启老师论文选题流程</td>";
                    }
                    ?>


                    <td class="col-xs-2 th-title-center">
                        <?php

                        if ($row_control['topic'] == 0) {
                            echo "<a href='sec_chang_t_control_value.php?func=topic' 
                                class='btn btn-primary' role='button'
                                onclick=\"Javascript:return confirm('确定开启么？此操作不可逆转')\">开启选题</a>";
                        } else if ($row_control['topic'] == 1) {
                            echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                        }
                        ?>
                    </td>


                </tr>
                <tr>
                    <td class="col-xs-5 th-title-center">开题
                        <?php
                        if (!$row_control['first_report_deadline']) {
                            echo "";
                        } else {
                            echo "(截止时间为：";
                            echo $row_control['first_report_deadline'];
                            echo "）";
                        }
                        ?>
                    </td>
                    <?php
                    //查看当前提交最终报告学生的数量
                    $sql_final_first_report = "SELECT * from `first_report_record` where `final_flag` = 4";
                    $result_final_first_report = mysqli_query($link, $sql_final_first_report);
                    $num_final_first_report = mysqli_num_rows($result_final_first_report);

                    //查看当前学生人数
                    $sql_user = "SELECT * FROM `user` where `permission` = 'student' ";
                    $result_user = mysqli_query($link, $sql_user);
                    $num_user = mysqli_num_rows($result_user);

                    //当前时间
                    //$today & $row_control['first_report_deadline']

                    if ((($today > $row_control['first_report_deadline']) && ($row_control['first_report'] == 0) && ($row_control['first_report_deadline'] != NULL))
                        || (($num_final_first_report == $num_user) && ($row_control['first_report'] == 0))
                    ) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-info\" >";
                        echo "当前学生已全部全部上交开题报告最终稿或超过提交截止日期，可以开启老师开题流程";
                    } else if (($row_control['first_report'] == 1)) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-info\" >";
                        echo "已开启老师开题流程";
                    } else {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\">";
                        echo "当前时间未超过截止日期且学生尚未全部上交开题报告最终稿，不可开启老师开题流程";
                        echo "<a data-toggle=\"modal\" data-target=\"#unupload_list\">(查看未提交名单)</a>";
                    }
                    ?>
                    </td>

                    <td class="col-xs-2 th-title-center">
                        <?php
                        if ((($today > $row_control['first_report_deadline']) && ($row_control['first_report'] == 0)  && ($row_control['first_report_deadline'] != NULL))
                            || (($num_final_first_report == $num_user) && ($row_control['first_report'] == 0))
                        ) {
                            echo "<a href='sec_chang_t_control_value.php?func=first_report' 
                                class='btn btn-primary' role='button'
                                onclick=\"Javascript:return confirm('确定开启么？此操作不可逆转')\">开启选题</a>";
                        } else if (($row_control['first_report'] == 1)) {
                            echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                        } else {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        }
                        ?>
                    </td>


                </tr>
                <tr>
                    <!-- 
                        论文初稿开启条件：
                        无特殊开启条件，由答辩秘书自行控制
                     -->
                    <td class="col-xs-5 th-title-center">中期报告
                        <?php
                        if (!$row_stu_control['midterm_deadline']) {
                            echo "";
                        } else {
                            echo "(截止时间为：";
                            echo $row_stu_control['midterm_deadline'];
                            echo "）";
                        }
                        ?>
                    </td>
                    <?php

                    if ((!$row_stu_control['midterm_deadline']) && $row_stu_control['midterm_deadline'] == NULL) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\">";
                        echo "请根据学校要求在学生流程控制界面及时设置截止日期并打开论文初稿提交流程";
                    } elseif ((!$row_control['first_report'])) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\">";
                        echo "当前开题流程尚未完全开启";
                    } else {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-info\">";
                        echo "已开启老师中期流程";
                    }
                    ?>
                    </td>

                    <td class="col-xs-2 th-title-center">
                        <?php
                        if ((!$row_stu_control['midterm_deadline']) && $row_stu_control['midterm_deadline'] == NULL) {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        } elseif ((!$row_control['first_report'])) {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        } else {
                            echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                        }

                        ?>
                    </td>


                </tr>
                <tr>
                    <!-- 
                        论文初稿开启条件：
                        无特殊开启条件，由答辩秘书自行控制
                     -->
                    <td class="col-xs-5 th-title-center">论文初稿
                        <?php
                        if (!$row_stu_control['first_paper_deadline']) {
                            echo "";
                        } else {
                            echo "(截止时间为：";
                            echo $row_stu_control['first_paper_deadline'];
                            echo "）";
                        }
                        ?>
                    </td>
                    <?php

                    if ((!$row_stu_control['first_paper']) && $row_stu_control['first_paper_deadline'] == NULL) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\">";
                        echo "请根据学校要求在学生流程控制界面及时设置截止日期并打开论文初稿提交流程";
                    } elseif ((!$row_control['first_paper'])) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\">";
                        echo "请根据学校要求及时打开论文初稿提交流程";
                    } else {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-info\">";
                        echo "已开启学生论文初稿流程";
                    }
                    ?>
                    </td>

                    <td class="col-xs-2 th-title-center">
                        <?php
                        if ((!$row_stu_control['first_paper']) && $row_stu_control['first_paper_deadline'] == NULL) {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        } elseif ((!$row_control['first_paper'])) {
                            echo "<a href='sec_chang_t_control_value.php?func=first_paper' 
                                class='btn btn-primary' role='button'
                                onclick=\"Javascript:return confirm('确定开启么？此操作不可逆转')\">开启论文初稿</a>";
                        } else {
                            echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                        }

                        ?>
                    </td>


                </tr>
                <tr>
                    <!-- 
                        一次答辩开启条件：
                            必须等待所有延期答辩申请审核结束

                            ***注意此处是审核结束，不是到达截止时间，注意区别。
                            此处实现需要查询时候不存在申请状态码为2的学生，如果存在即表示有学生的申请未完成审核
                     -->
                    <td class="col-xs-5 th-title-center">一次答辩</td>
                    <?php
                    //查看当前时候已有学生
                    $sql_ishave = "SELECT * FROM `reply_schedule` where `permission` = 'student'";
                    $result_ishave = mysqli_query($link, $sql_ishave);
                    $num_ishave = mysqli_num_rows($result_ishave);

                    //查看当前所有申请状态 = 2的学生
                    $sql_delay = "SELECT * FROM `reply_schedule` where `reply_delay` =2";
                    $result_delay = mysqli_query($link, $sql_delay);
                    $num_delay = mysqli_num_rows($result_delay);

                    //查看当前所有答辩安排详情
                    $sql_detail = "SELECT * FROM `reply_schedule` where `reply_schedule`.`place` is NULL";
                    $result_detail = mysqli_query($link, $sql_detail);
                    $num_detail = mysqli_num_rows($result_detail);
                    if (!$num_ishave) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                        echo "当前一辩评分工作尚未完成，请等待导师评分完成";
                    } elseif ($num_ishave) {
                        if ($num_delay != 0 && $row_control['first_reply'] == 0) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                            echo "当前延期答辩审核尚未全部完成，不可开启老师一次答辩流程";
                        } elseif ($num_delay == 0 && $row_control['first_reply'] == 0 && $num_detail) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                            echo "当前答辩详情安排尚未全部完成，请及时完善答辩详情信息";
                        } else if ($num_delay == 0 && $row_control['first_reply'] == 0 && !$num_detail) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-info\" >";
                            echo "当前可以开启老师一次答辩流程，请根据学校要求及时开启";
                        } else {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-info\">";
                            echo "当前老师一次答辩流程已开启";
                        }
                    }
                    ?>
                    </td>



                    <td class="col-xs-2 th-title-center">
                        <?php
                        if (!$num_ishave) {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        } elseif ($num_ishave) {
                            if ($num_delay != 0 && $row_control['first_reply'] == 0) {
                                echo "<button class='btn btn-warning' disabled>不可操作</button>";
                            } elseif ($num_delay == 0 && $row_control['first_reply'] == 0 && $num_detail) {
                                echo "<button class='btn btn-warning' disabled>不可操作</button>";
                            } else if ($num_delay == 0 && $row_control['first_reply'] == 0 && !$num_detail) {
                                echo "<a href='sec_chang_t_control_value.php?func=first_reply' 
                                class='btn btn-primary' role='button'
                                onclick=\"Javascript:return confirm('确定开启么？此操作不可逆转')\">开启一辩</a>";
                            } else {
                                echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                            }
                        }
                        ?>
                    </td>


                </tr>

                <tr>
                    <!-- 
                        一次答辩评分开启条件：
                            必须等待所有一次答辩结束

                            即答辩秘书已上传所有一辩学生的答辩记录
                     -->
                    <td class="col-xs-5 th-title-center">一次答辩评分</td>
                    <?php
                    //查看当前时候已有学生
                    $sql_ishave = "SELECT * FROM `reply_schedule` where `permission` = 'student'";
                    $result_ishave = mysqli_query($link, $sql_ishave);
                    $num_ishave = mysqli_num_rows($result_ishave);

                    //查看当前所有一辩学生的数量
                    $sql_first = "SELECT * FROM `reply_schedule` where `permission` = 'student' 
                    AND `first_paper_flag` = 1 AND `reply_delay`=0 ";
                    $result_first = mysqli_query($link, $sql_first);
                    $num_first = mysqli_num_rows($result_first);

                    //查看当前所有答辩记录数量
                    $sql_record = "SELECT * FROM `reply_record` where 1";
                    $result_record = mysqli_query($link, $sql_record);
                    $num_record = mysqli_num_rows($result_record);
                    if (!$num_ishave) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                        echo "当前答辩记录尚未全部上传完成，不可开启老师一次答辩评分流程";
                    } elseif ($num_ishave) {
                        if ($num_first > $num_record) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                            echo "当前答辩记录尚未全部上传完成，不可开启老师一次答辩评分流程";
                        } else if ($num_first == $num_record && !$row_control['first_reply_grade']) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-info\" >";
                            echo "当前可以开启老师一次答辩评分流程，请根据学校要求及时开启";
                        } else {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-info\">";
                            echo "当前老师一次答辩评分流程已开启";
                        }
                    }
                    ?>
                    </td>
                    <td class="col-xs-2 th-title-center">
                        <?php
                        if (!$num_ishave) {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        } elseif ($num_ishave) {
                            if ($num_first > $num_record) {
                                echo "<button class='btn btn-warning' disabled>不可操作</button>";
                            } elseif ($num_first == $num_record && !$row_control['first_reply_grade']) {
                                echo "<a href='sec_chang_t_control_value.php?func=first_reply_grade' 
                                class='btn btn-primary' role='button'
                                onclick=\"Javascript:return confirm('确定开启么？此操作不可逆转')\">开启评分</a>";
                            } else {
                                echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                            }
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <!-- 
                        二次答辩评分开启条件：
                            必须等待所有二次答辩结束

                            即答辩秘书已上传所有二辩学生的答辩记录
                     -->
                    <td class="col-xs-5 th-title-center">二次答辩评分</td>
                    <?php
                    //查看当前时候已有学生
                    $sql_ishave = "SELECT * FROM `second_reply_schedule` where `permission` = 'student'";
                    $result_ishave = mysqli_query($link, $sql_ishave);
                    $num_ishave = mysqli_num_rows($result_ishave);

                    //查看当前所有二辩学生的数量
                    $sql_second = "SELECT * FROM `second_reply_schedule` where `permission` = 'student'";
                    $result_second = mysqli_query($link, $sql_second);
                    $num_second = mysqli_num_rows($result_second);

                    //查看当前所有答辩记录数量
                    $sql_record = "SELECT * FROM `reply_record` where `reply_record_annex_name` is NULL ";
                    $result_record = mysqli_query($link, $sql_record);
                    $num_no_record = mysqli_num_rows($result_record);

                    if (!$num_ishave) {
                        echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                        echo "当前二次答辩记录尚未全部上传完成，不可开启老师一次答辩评分流程";
                    } elseif ($num_ishave) {
                        if ($num_no_record!=0) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-warning\" >";
                            echo "当前二次答辩记录尚未全部上传完成，不可开启老师一次答辩评分流程";
                        } else if ($num_no_record == 0 && !$row_control['second_reply_grade']) {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-info\" >";
                            echo "当前可以开启老师二次答辩评分流程，请根据学校要求及时开启";
                        } else {
                            echo "<td class=\"col-xs-5 th-title-center alert alert-info\">";
                            echo "当前老师二次答辩评分流程已开启";
                        }
                    }
                    ?>
                    </td>
                    <td class="col-xs-2 th-title-center">
                        <?php
                        if (!$num_ishave) {
                            echo "<button class='btn btn-warning' disabled>不可操作</button>";
                        } elseif ($num_ishave) {
                            if ($num_no_record!=0) {
                                echo "<button class='btn btn-warning' disabled>不可操作</button>";
                            } elseif ($num_no_record == 0 && !$row_control['second_reply_grade']) {
                                echo "<a href='sec_chang_t_control_value.php?func=second_reply_grade' 
                                class='btn btn-primary' role='button'
                                onclick=\"Javascript:return confirm('确定开启么？此操作不可逆转')\">开启评分</a>";
                            } else {
                                echo "<a class='btn btn-primary' role='button' disabled>已开启</a>";
                            }
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="unupload_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">人员名单</h4>
                </div>
                <div class="modal-body">
                    <?php
                    //已提交人员名单
                    $sql_do = "SELECT * FROM `first_report_record` WHERE `final_flag` = 4";
                    $result_do = mysqli_query($link, $sql_do);
                    $num_do = mysqli_num_rows($result_do);

                    //全员名单
                    $sql_user = "SELECT * FROM `user` WHERE `permission` = 'student'";
                    $result_user = mysqli_query($link, $sql_user);
                    $num_user = mysqli_num_rows($result_user);
                    echo <<< archemiya
                <div class="fixed-table-container">
                <table width="100%">
                    <tr>
                        <td width="50%" style="float: left;margin: 0px;padding: 0px;">
                            <table id="table1" class="table col-md-6" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th >
                                            <div class="th-inner th-title-center" >已提交学生名单</div>
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody >
archemiya;
                    for ($i = 0; $i < $num_do; $i++) {
                        $row_do = mysqli_fetch_array($result_do, MYSQLI_BOTH);
                        $students_do[$i] = $row_do['student_id'] . $row_do['student_name'];
                    }
                    for ($i = 0; $i < $num_do; $i++) {
                        echo "<tr>";

                        echo "<td class='alert alert-info td-title-center td-height' role='alert'>";
                        echo $students_do[$i];
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo <<< archemiya
                                    
                                </tbody>
                            </table>

                        </td>
                        <td width="50%" style="float: right;margin: 0px;padding: 0px;">
                            <table id="table2" class="table col-md-6" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th >
                                            <div class="th-inner th-title-center" >未提交学生名单</div>
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody >
archemiya;
                    for ($i = 0; $i < $num_user; $i++) {
                        $row_user_array = mysqli_fetch_array($result_user, MYSQLI_BOTH);
                        $students[$i] = $row_user_array['id'] . $row_user_array['name'];
                    }
                    for ($i = 0; $i < $num_user; $i++) {
                        for ($j = 0; $j < $num_do; $j++) {
                            if (($students[$i] == $students_do[$j])) {
                                unset($students[$i]);
                                break;
                            }
                        }
                        if (isset($students[$i])) {
                            echo "<tr>";
                            echo "<td class='alert alert-danger td-title-center td-height' role='alert'>";
                            echo $students[$i];
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    echo <<< archemiya
                                            
                                        </tbody>
                                    </table>

                                </td>

                            </tr>
                        </table>
                    </div>

archemiya;
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>