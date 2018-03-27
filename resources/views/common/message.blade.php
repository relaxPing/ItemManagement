<!-- 成功提示框 -->
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>成功!</strong> {{Session::get('success')}}
    <audio id="chatAudio">
        <source src="audio/success.ogg" />
        <source src="audio/success.mp3" />
        <source src="audio/success.wav" />
    </audio>
    <?php
    echo "<script>$('#chatAudio')[0].play()</script>";
    ?>
</div>
@endif
<!-- 失败提示框 -->
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>失败!</strong> {{Session::get('error')}}
    <audio id="chatAudio">
        <source src="audio/error.ogg" />
        <source src="audio/error.mp3" />
        <source src="audio/error.wav" />
    </audio>
    <?php
    echo "<script>$('#chatAudio')[0].play()</script>";
    ?>
</div>
@endif