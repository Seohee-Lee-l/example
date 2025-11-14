<?
    session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>고객의 소리</title>    
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/board.css">
    <link rel="stylesheet" href="css/haitai.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/xeicon/2/xeicon.min.css">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/board.js"></script>
</head>

<body>
    <?php
        session_start();
        include "dbconn.php";
        $mode=isset($_GET['mode']) ? $_GET['mode'] : "";
        $page=isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $find=isset($_POST['find']) ? $_POST['find'] : "";
        $search=isset($_POST['search']) ? $_POST['search'] : "";

        $scale=10;

        if ($mode=='search') {
            if (!$search) {
                echo("
                    <script>
                        window.alert('검색할 단어를 입력해주세요.');
                        history.go(-1);
                    </script>
                ");
                exit;
            }

            // SQL 인젝션 방지를 위한 이스케이프 처리
            $find = mysqli_real_escape_string($connect, $find);
            $search = mysqli_real_escape_string($connect, $search);
            $sql= "select * from haitai_board where $find like '%$search%' order by idx desc";
        } else {
            $sql="select * from haitai_board order by idx desc";
        }

        $result=mysqli_query($connect, $sql);
        
        // 쿼리 실행 오류 체크
        if (!$result) {
            die("쿼리 실행 오류: " . mysqli_error($connect));
        }
        
        $total_record=mysqli_num_rows($result);

        if ($total_record%$scale==0) {
            $total_page=floor($total_record/$scale);
        } else {
            $total_page=floor($total_record/$scale)+1;
        }

        if ($total_page<1) {
            $total_page=1;
        }

        if (!$page) {
            $page=1;
        }

        $start=($page-1)*$scale;
        $number=$total_record-$start;
    ?>

    <div id='board-section'>
        <div class='board-title'>
            <h2>고객의 소리</h2>
        </div>

        <div class='list-search'>
            <form action="list.php?mode=search" method='post' name='board_form'>
                <select name="find">
                    <option value="subject">제목</option>
                    <option value="content">내용</option>
                    <option value="name">작성자</option>
                </select>

                <input type="text" name='search'>

                <button type='submit'>검색</button>
            </form>
        </div>

        <div class='board-list'>
            <ul>
                <li>No.</li>
                <li>제목</li>
                <li>작성자</li>
                <li>작성일</li>
                <li>조회수</li>
            </ul>
        </div>

        <div id='list_content'>
            <?php
                for ($i=$start; $i<$start+$scale && $i<$total_record; $i++) {
                    mysqli_data_seek($result, $i);
                    $row=mysqli_fetch_array($result);

                    $item_idx=$row['idx'];
                    $item_name=$row['name'];
                    $item_subject=str_replace(" ", "&nbsp;", $row['subject']);
                    $item_hit=$row['hit'];
                    $item_regdate=$row['regdate'];
            ?>

            <div id='list_item'>
                <div id='list_item1'><?=$number?></div>
                <div id='list_item2'><a href="view.php?num=<?=$item_idx?>&page=<?=$page?>"><?=$item_subject ?></a></div>
                <div id='list_item3'><?=$item_name?></div>
                <div id='list_item4'><?=$item_regdate?></div>
                <div id='list_item5'><?=$item_hit?></div>
            </div>

            <?php
                $number--;
                }
            ?>

            <div id='page_button'>
                <div id='page_num'>
                    <?php
                        if ($page >1):
                    ?>
                        <a href="list.php?page=<?=$page-1?>">
                            <i class='xi-arrow-left'></i>
                        </a>
                    <?php else: ?>
                        <i class='xi-arrow-left'></i>
                    <?php endif; ?>                    <?php
                        for ($i=1; $i<=$total_page; $i++) {
                            if ($page==$i) {
                                echo "<b> $i </b>";
                            } else {
                                echo "<a href='list.php?page=$i'> $i </a>";
                            }
                        }
                    ?>

                    <?php
                        if ($page<$total_page): ?>
                        <a href="list.php?page=<?=$page+1?>">
                            <i class='xi-arrow-right'></i>
                        </a>
                    <?php else: ?>
                        <i class='xi-arrow-right'></i>
                    <?php endif; ?>
                </div>
            </div>

            <div id='button'>
                <a href="write_form.php?page=<?=$page?>">글쓰기</a>
            </div>
        </div>
    </div>
</body>

</html>