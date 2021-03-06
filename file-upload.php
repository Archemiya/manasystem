<?php
// linux下输出中文名
function sbasename($filename)
{
  return preg_replace('/^.+[\\\\\\/]/', '', $filename);
}

//此php为系统所有上传文件脚本，使用get方式传参，对参数进行判断后选择上传各类别文件
$uploaddir = './uploaded_files/';
$uploadfilename = sbasename($_FILES['file']['name']);


// echo $uploadfilename;
if ((($_FILES["file"]["type"] == "application/msword")
    || ($_FILES["file"]["type"] == "application/pdf")
    || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
  && ($_FILES["file"]["size"] < 10000000)
) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
  } else {
    include "link.php";
    switch ($_GET['func']) { //根据参数func值进行判断
      case "first_report":
        $num = $_POST['num'];
        if (!$num) {
          echo "<script>alert('您还未上传开题报告！请先上传开题报告');history.go(-1)</script>";
        } else {
          $uploadfile = $uploaddir . 'first_report_files/' . $uploadfilename;
          move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
          //echo $uploadfilename;
          $topic_id = $_POST['topic_id'];

          $sql_id = "SELECT max(`record_id`) from `first_report_record` 
          where `topic_id` = '{$topic_id}' order by `record_id` desc";
          $result_id = mysqli_query($link, $sql_id);
          $row_id = mysqli_fetch_array($result_id, MYSQLI_BOTH);
          $sql = "UPDATE `first_report_record` SET `first_report_annex_name` = '{$uploadfilename}',`annex_flag` = 1
          WHERE  `first_report_record`.`topic_id`= '{$topic_id}' AND `record_id` = '{$row_id['max(`record_id`)']}'";

          mysqli_query($link, $sql);
          echo "<script>alert('上传附件成功！');history.go(-1)</script>";
        }
        mysqli_close($link);
        break;

      case "midterm_report":
        $num = $_POST['num'];
        if (!$num) {
          echo "<script>alert('您还未上传中期报告！请先上传中期报告');history.go(-1)</script>";
        } else {
          $uploadfile = $uploaddir . 'midterm_report_files/' . $uploadfilename;
          move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
          //echo $uploadfilename;
          $topic_id = $_POST['topic_id'];

          $sql_id = "SELECT max(`record_id`) from `midterm_report` 
          where `topic_id` = '{$topic_id}' order by `record_id` desc";
          $result_id = mysqli_query($link, $sql_id);
          $row_id = mysqli_fetch_array($result_id, MYSQLI_BOTH);

          $sql = "UPDATE `midterm_report` SET `midterm_report_annex_name` = '{$uploadfilename}',`annex_flag` = 1
          WHERE  `midterm_report`.`topic_id`= '{$topic_id}' AND `record_id` = '{$row_id['max(`record_id`)']}'";

          mysqli_query($link, $sql);
          echo "<script>alert('上传附件成功！');history.go(-1)</script>";
        }
        mysqli_close($link);
        break;

      case "first_paper":
        $sql_id = "SELECT max(`record_id`) from `first_paper_record` 
        where `topic_id` = '{$_POST['topic_id']}' order by `record_id` desc";
        $result_id = mysqli_query($link, $sql_id);
        $row_id = mysqli_fetch_array($result_id, MYSQLI_BOTH);

        $newdir = "./uploaded_files/first_paper_files/" . $_POST['student_id'] . '_' . $row_id['max(`record_id`)'];
        mkdir("{$newdir}");

        $uploadfile = $newdir . "/" . $uploadfilename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        $topic_id = $_POST['topic_id'];
        $sql = "UPDATE `first_paper_record` SET `first_paper_annex_name` = '{$uploadfilename}',`annex_flag` = 1
        WHERE  `first_paper_record`.`topic_id`= '{$topic_id}' AND `record_id` = '{$row_id['max(`record_id`)']}'";
        mysqli_query($link, $sql);
        echo "<script>alert('上传附件成功！');history.go(-1)</script>";
        mysqli_close($link);
        break;
        
      case "final_paper":
        $sql_id = "SELECT max(`record_id`) from `final_paper_record` 
        where `topic_id` = '{$_POST['topic_id']}' order by `record_id` desc";
        $result_id = mysqli_query($link, $sql_id);
        $row_id = mysqli_fetch_array($result_id, MYSQLI_BOTH);

        $newdir = "./uploaded_files/final_paper_files/" . $_POST['student_id'] . '_' . $row_id['max(`record_id`)'];
        mkdir("{$newdir}");

        $uploadfile = $newdir . "/" . $uploadfilename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        $topic_id = $_POST['topic_id'];
        $sql = "UPDATE `final_paper_record` SET `final_paper_annex_name` = '{$uploadfilename}',`annex_flag` = 1
        WHERE  `final_paper_record`.`topic_id`= '{$topic_id}' AND `record_id` = '{$row_id['max(`record_id`)']}'";
        mysqli_query($link, $sql);
        echo "<script>alert('上传附件成功！');history.go(-1)</script>";
        mysqli_close($link);
        break;

      case "delay_reply":
        $newdir = "./uploaded_files/delay_report_files/" . $_POST['student_id'];
        mkdir("{$newdir}");

        $uploadfile = $newdir . "/" . $uploadfilename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        $topic_id = $_POST['topic_id'];
        $student_id = $_POST['student_id'];
        $student_name = $_POST['student_name'];
        $delay_description = $_POST['delay_description'];
        $sql = "UPDATE `reply_schedule` 
        SET 
        `delay_annex_name` = '{$uploadfilename}',
        `reply_delay` = 2,
        `delay_description` = '{$delay_description}'
        WHERE  `reply_schedule`.`id`= '{$student_id}'";
        mysqli_query($link, $sql);
        echo "<script>alert('提交申请成功！');history.go(-1)</script>";
        mysqli_close($link);
        break;

      case "reply_record":
        $newdir = "./uploaded_files/reply_record_files/" . $_POST['student_id'];
        mkdir("{$newdir}");

        $uploadfile = $newdir . "/" . $uploadfilename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        $topic_id = $_POST['topic_id'];
        $topic_name = $_POST['topic_name'];
        $student_id = $_POST['student_id'];
        $student_name = $_POST['student_name'];
        $teacher_id = $_POST['teacher_id'];
        $teacher_name = $_POST['teacher_name'];

        $sql = "INSERT INTO `reply_record` 
        (`topic_id`, 
        `topic_name`,
        `student_id`, 
        `student_name`, 
        `teacher_id`, 
        `teacher_name`, 
        `reply_record_annex_name`) 
        VALUES 
        ('{$topic_id}', 
        '{$topic_name}', 
        '{$student_id}', 
        '{$student_name}', 
        '{$teacher_id}', 
        '{$teacher_name}', 
        '{$uploadfilename}')";
        mysqli_query($link, $sql);
        echo "<script>alert('上传附件成功！');history.go(-1)</script>";
        mysqli_close($link);
        break;

      case "second_reply_record":
        $newdir = "./uploaded_files/reply_record_files/" . $_POST['student_id'];
        mkdir("{$newdir}");

        $uploadfile = $newdir . "/" . $uploadfilename;
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        $topic_id = $_POST['topic_id'];
        $topic_name = $_POST['topic_name'];
        $student_id = $_POST['student_id'];
        $student_name = $_POST['student_name'];
        $teacher_id = $_POST['teacher_id'];
        $teacher_name = $_POST['teacher_name'];

        $sql = "UPDATE `reply_record` 
        set `reply_record_annex_name`= '{$uploadfilename}'
        where `student_id` = '{$student_id}' ";
        mysqli_query($link, $sql);
        echo "<script>alert('上传附件成功！');history.go(-1)</script>";
        mysqli_close($link);
        break;
    }
  }
} else if ($_FILES["file"]["size"] >= 10000000) {
  echo "<script>alert('文件过大超过10M！请重新上传');history.go(-1)</script>";
} else if (($_FILES["file"]["type"] != "application/msword")
  || ($_FILES["file"]["type"] != "application/pdf")
  || ($_FILES["file"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
) {
  echo $_FILES["file"]["type"];

  //echo "<script>alert('只允许上传doc/docx/pdf格式文件！请重新上传');history.go(-1)</script>";
}
