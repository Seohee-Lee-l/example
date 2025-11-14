<?php
    session_start();
    include "dbconn.php";

    $num = isset($_GET['num']) ? (int)$_GET['num'] : 0;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $sql = "select * from haitai_board where idx=$num";
    $result = mysqli_query($connect, $sql);
    
    if (!$result) {
        die("쿼리 실행 오류: " . mysqli_error($connect));
    }
    
    $row = mysqli_fetch_array($result);
    
    if (!$row) {
        echo "<script>alert('존재하지 않는 게시글입니다.'); location.href='list.php';</script>";
        exit;
    }

    $item_num = $row['idx'];
    $item_name = $row['name'];
    $item_subject = str_replace(" ", "&nbsp;", $row['subject']);
    $item_content = nl2br($row['content']);
    $item_date = $row['regdate'];
    $item_hit = $row['hit'];

    $new_hit = $item_hit + 1;

    $update_sql = "update haitai_board set hit=$new_hit where idx=$num";
    mysqli_query($connect, $update_sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/board.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/xeicon/2/xeicon.min.css">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/board.js"></script>    
    
    <script>
        function del(href) {
            if (confirm("정말 삭제하시겠습니까?")) {
                location.href = href;
                return false;
            }
            return false;
        }        
        
        function modify_pass() {
            const userPassword = document.getElementById('write_pass').value;
            const correctPassword = '<?=$row['write_pass']?>';
            
            if (userPassword === '') {
                window.alert('게시글 비밀번호를 입력해주세요.');
                return false;
            }
            
            if (userPassword === correctPassword) {
                location.href='modify_form.php?num=<?=$num?>&page=<?=$page?>';
                return true;
            } else {
                window.alert('게시글 비밀번호가 일치하지 않습니다.');
                return false;
            }
        }

        function delete_pass() {
            const userPassword = document.getElementById('write_pass').value;
            const correctPassword = '<?=$row['write_pass']?>';
            
            if (userPassword === '') {
                window.alert('게시글 비밀번호를 입력해주세요.');
                return false;
            }
            
            if (userPassword === correctPassword) {
                if (confirm('정말 삭제하시겠습니까?')) {
                    location.href='delete.php?num=<?=$num?>&page=<?=$page?>';
                }
                return true;
            } else {
                window.alert('게시글 비밀번호가 일치하지 않습니다.');
                return false;
            }
        }        
        
        // 입력 필드에서 엔터 키 누를 때 처리
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('write_pass');
            passwordInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    modify_pass();
                }
            });
        });
    </script>
</head>

<body>
    <div id='view_wrap'>
        <div id='content'>
            <div id='view_box'>
                <div id='view_title'>
                    <h3>
                        <?=$item_subject?>
                    </h3>
                </div>

                <div id='view_info'>
                    <div id='info'>                        
                        <p class='info_txt'>
                            <?=$item_name?>
                            | View : 
                            <?=$new_hit?>
                            |
                            <?=$item_date?>
                        </p>
                    </div>
                </div>

                <div id='view_content'>
                    <?=$item_content?>
                </div>                
                
                <div id='password'>
                    <p>작성자만 글 수정, 삭제가 가능합니다</p>

                    <div class="password-input-box">
                        <input type="password" name='write_pass' id='write_pass' placeholder="비밀번호를 입력하세요">
                    </div>
                </div>                
                
                <div id='view_button'>
                    <button onclick="modify_pass()" id='edit-btn'>수정</button>
                    <button type="button" id="delete-btn" onclick="delete_pass()">삭제</button>

                    <a href="list.php?page=<?=$page?>">
                        <button>목록</button>
                    </a>

                    <a href="write_form.php?page=<?=$page?>">
                        <button type='button'>
                            글쓰기
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>