function QuestionTimer(left, time) 
{
    var timer = left, minutes, seconds;
    setInterval(function () 
    {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        time.textContent = minutes + ":" + seconds;
        if (--timer < 0) 
        {
            var next = document.getElementById("NextQuest");
            next.click();
        }
    }, 1000);
}

// function Timer(to_left) 
// {
//     var left = 60 * to_left, time = document.getElementById('timer');
//     QuestionTimer(left, time);
// };

window.onload = function() 
{
    var left = 60 * 0.5, time = document.getElementById('timer');
    QuestionTimer(left, time);
};
