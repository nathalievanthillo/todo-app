function addComment(eventArgs){
    var taskId = eventArgs.path[0].dataset.taskid;
    var commentText = eventArgs.path[0].previousElementSibling.value;
    
    var formData = new FormData();

    formData.append("taskId", taskId);
    formData.append("commentText", commentText);

    fetch("./ajax_commands/addCommentToTask.php", {
        method: "POST",
        body:formData
    })
        .then(response => response.json())
        .then(result => {

            alert("comment geplaatst");
            
        })
        .catch(error => {
            console.error("Error:", error);
        });


    
    
}

var commentBoxes = document.getElementsByClassName("commentBox");//zoeken naar alle divs met klasse commentBox 

for(i=0; i<commentBoxes.length; i++){
    commentBoxes[i].getElementsByClassName('commentBoxButton')[0].onclick = addComment; //binnen commentBox div zoeken naar de commentbox button
}