<?php
    $num = isset($_GET['num']) ? (int)$_GET['num'] : 0;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    
    include "dbconn.php";

    if ($num == 0) {
        echo("
            <script>
                window.alert('잘못된 접근입니다.');
                location.href = 'list.php?page=$page';
            </script>
        ");
        exit;
    }

    // 게시글 삭제 (view.php에서 이미 비밀번호 확인됨)
    $sql = "delete from haitai_board where idx=$num";
    $result = mysqli_query($connect, $sql);
    
    if ($result) {
        mysqli_close($connect);
        echo "
            <script>
                alert('게시글이 삭제되었습니다.');
                location.href='list.php?page=$page';
            </script>
        ";
    } else {
        mysqli_close($connect);
        echo "
            <script>
                alert('삭제 중 오류가 발생했습니다.');
                history.back();
            </script>
        ";
    }
?>