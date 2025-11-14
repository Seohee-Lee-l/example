<?php
    include "dbconn.php";

    // POST 데이터 받기
    $username=$_POST['name'];
    $subject=$_POST['subject'];
    $content=$_POST['content'];
    $email=$_POST['email'];
    $password=$_POST['write_pass'];
    $regdate=date("Y-m-d H:i:s");
    $page=isset($_POST['page']) ? (int)$_POST['page'] : 1;

    if (isset($_GET['mode'])) {
        $mode=$_GET['mode'];
    } else {
        $mode="";
    }    
    
    if ($mode=='modify') {
        $num=$_POST['num'];
        
        // 기존 비밀번호 확인
        $check_sql="select write_pass from haitai_board where idx=$num";
        $check_result=mysqli_query($connect, $check_sql);
        $check_row=mysqli_fetch_array($check_result);
        
        if ($check_row['write_pass'] !== $password) {
            echo "
                <script>
                    alert('비밀번호가 일치하지 않습니다.');
                    history.back();
                </script>
            ";
            exit;
        }
        
        $sql="update haitai_board set name='$username', email='$email', subject='$subject', content='$content', write_pass='$password' where idx=$num";
    } else {
        $sql="insert into haitai_board (name, email, subject, content, write_pass, regdate, hit) ";
        $sql.="values('$username', '$email', '$subject', '$content', '$password', '$regdate', 0)";
    }    mysqli_query($connect, $sql);
    mysqli_close($connect);

    if ($mode=='modify') {
        echo "
            <script>
                alert('수정이 완료되었습니다.');
                location.href='view.php?num=$num&page=$page';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('등록이 완료되었습니다.');
                location.href='list.php?page=$page';
            </script>
        ";
    }