<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMD</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        body{
            background:#000;
            color:#0f0;
        }
        *{
            background:transparent;
            color:white;
        }
        .btn-green{
            background:green;
            color:white;
            border:1px solid #999;
            padding:0.4rem 1rem;
            border-radius:10px;
            cursor:pointer;
            margin-top:1rem;
        }
        .btn:hover{
            background:lightgreen;
        }
        input:focus{
            outline:none;
        }
        input{
            border:none;
        }
    </style>
</head>
<body>
        <div id="message" class="message"></div>
        <input  id="request" autofocus name="request" placeholder="Enter command" style="width:100%;min-height:200px;">
        <button class="btn btn-green">Run</button>
    <script>
        $(".btn-green").on("click", function(){
            $.post("cmd-script",{
                request: $("#request").val()
            },function (response) {
                if(response.success){
                    $("#message").html($("#message").html() + `<span style='color:green;'>${response.message}</span><br>`);
                    $("#request").val('');
                }else{
                    $("#message").html($("#message").html() + `<span style='color:red;'>${response.message}</span><br>`);
                    $("#request").val('');
                }

                    setTimeout(function(){
                    $("#message").html('');
                    },2000);

            }).fail(function (xhr,error,code){
                alert(JSON.stringify(xhr));
            });
        });
        
    </script>
</body>
</html>