$(document).ready(function () {
    var seldate = '';
    $('#seldate').change(
        function() {
            seldate = document.getElementById('seldate').value;
        }
    )
    $('#getday').click(
        function() {
            var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            if (seldate != '') {
                var temp = seldate.split(".");
                $.post('functions.php?index=1&month='+temp[0]+'&year='+temp[2]+'&day='+temp[1],function(data){
                    document.getElementById("description").innerHTML = '<h3>'+seldate+' is ' + days[data] + '</p>';
                    $('#seldate').val(seldate);
                })
                $.post('functions.php?index=2&month='+temp[0]+'&year='+temp[2]+'&day='+temp[1],function(content){
                    document.getElementById("custom").innerHTML = content;
                    var id = '#li-'+temp[2]+'-'+temp[0]+'-'+temp[1];
                    $(id).css("background-color", "lightgreen");;
                })
            }
        }
    )
})