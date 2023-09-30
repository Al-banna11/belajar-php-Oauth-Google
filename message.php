<?php
if(isset($_SESSION['message'])) :
?>

<div class="waspada peringatan-peringatan peringatan-acara memudar yang dapat ditutup" role="waspada">
    <strong>Hei! </strong> <?= $_SESSION['message']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="hideMessage()"></button>
</div>

<script>
    // Fungsi untuk menghilangkan pesan
    function hideMessage() {
        var messageDiv = document.querySelector('.peringatan-acara');
        if (messageDiv) {
            messageDiv.style.display = 'none';
        }
    }
</script>

<?php 
unset($_SESSION['message']);
endif;
?>


<style>


.waspada strong {
    font-weight: bold;
}

.waspada {
    padding: 5px;
    border: 1px solid #ccc;
    background-color:#28a745; 
    font-weight: 20px;
    margin-top: 10px;
    height: 40px;
    width: 290px;
border-radius: 5px;
color: #fff;
font-weight: medium;
}


.btn-close {
    float: right;
    font-size: 16px;
    font-weight: bold;
    line-height: 1;
    color: #28a745; 
    background-color: transparent;
    border: none;
    cursor: pointer;
}


.btn-close:hover {
    color: #fff; 
    background-color: #28a745; 
}

</style>