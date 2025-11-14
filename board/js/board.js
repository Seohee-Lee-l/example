$(function() {
    
});

function check_input() {
    const name = document.board_form.name.value;
    const subject = document.board_form.subject.value;
    const content = document.board_form.content.value;
    
    if (name.trim() == "") {
        alert("이름을 입력해주세요.");
        document.board_form.name.focus();
        return false;
    }
    
    if (subject.trim() == "") {
        alert("제목을 입력해주세요.");
        document.board_form.subject.focus();
        return false;
    }
    
    if (content.trim() == "") {
        alert("내용을 입력해주세요.");
        document.board_form.content.focus();
        return false;
    }
    
    return true;
}