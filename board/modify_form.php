<?php
    include "dbconn.php";

    $num=$_GET['num'];
    $page=$_GET['page'];

    $sql="select * from haitai_board where idx=$num";
    $result=mysqli_query($connect, $sql);
    $row=mysqli_fetch_array($result);

    $item_subject=$row['subject'];
    $item_content=$row['content'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>고객의 소리</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/board.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/xeicon/2/xeicon.min.css">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/board.js"></script>    
    
    <script>
        function check_input() {
            if (!document.board_form.subject.value) {
                window.alert('제목을 입력해주세요.');
                document.board_form.subject.focus();
                return false;
            }

            if (!document.board_form.content.value) {
                window.alert('내용을 입력해주세요.');
                document.board_form.content.focus();
                return false;
            }

            if (!document.board_form.write_pass.value) {
                window.alert('게시글 비밀번호를 입력해주세요.');
                document.board_form.write_pass.focus();
                return false;
            }

            if (!document.board_form.name.value) {
                window.alert('이름을 입력해주세요.');
                document.board_form.name.focus();
                return false;
            }

            if (!document.board_form.email.value) {
                window.alert("이메일을 입력해주세요.");
                document.board_form.email.focus();
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <section id='write-section'>
        <div id='content-box'>
            <h3>문의 사항</h3>            
            
            <form action="insert_board.php?mode=modify" name='board_form' method='post' onsubmit='return check_input()'>
                <input type="hidden" name='page' value='<?=$page?>'>
                <input type="hidden" name='num' value='<?=$num?>'>

                <div id='write_form'>
                    <div class='write_line'></div>                    
                    
                    <div id='write_row1'>
                        <div class='col1'>이름</div>
                        <div class='col2'>
                            <input type="text" name='name' value="<?=$row['name']?>">
                        </div>
                    </div>
                    
                    <div id='write_row1_1'>
                        <div class='col1'>이메일</div>
                        <div class='col2'>
                            <input type="text" name='email' value="<?=$row['email']?>">
                        </div>
                    </div>

                    <div id='write_row2'>
                        <div class='col1'>제목</div>
                        <div class='col2'>
                            <input type="text" name='subject' value="<?=$item_subject?>">
                        </div>
                    </div>                    <div id='write_row3'>
                        <div class='col1'>내용</div>
                        <div class='col2'>
                            <textarea name="content" id="content" rows='15' cols='65'><?=$item_content?></textarea>
                        </div>
                    </div>
                    
                    <div id='write_row4'>
                        <div class='col1' id='write_pass'>비밀번호</div>
                        <div class='col2'>
                            <input type="password" name='write_pass' id='write_pass' placeholder="수정을 위해 비밀번호를 다시 입력하세요">
                        </div>
                    </div>
                </div>

                <div id='write_button'>
                    <button type='submit'>수정</button>
                    <a href="list.php?page=<?=$page?>">취소</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>