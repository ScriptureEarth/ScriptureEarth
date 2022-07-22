// JavaScript Document

function showMiniatura(path) {
	var imageName = $('#hrjpeg').val();
	var url = path+imageName;
	var img = '<img src="'+url+'">';
	var popup = window.open(url, "_blank", "location=no,height=150,width=250,scrollbars=no,status=no, menubar=no, titlebar=no, toolbar=no");
	popup.document.write(img);                        
}

function showGrande(path) {
	var imageName = $('#cuadro').val();
	var url = path+imageName;
	var img = '<img src="'+url+'">';
	var popup = window.open(url, "_blank", "location=no,height=450,width=660,scrollbars=no,status=no, menubar=no, titlebar=no, toolbar=no");
	popup.document.write(img);                        
}

function showImagen(path) {
	var imageName = $('#imagen').val();
	var url = path+imageName;
	var img = '<img src="'+url+'">';
	var popup = window.open(url, "_blank", "location=no,height=400,width=700,scrollbars=no,status=no, menubar=no, titlebar=no, toolbar=no");
	popup.document.write(img);                        
}

function showVideo(path) {
	var videoName = $('#video').val();
	var url = path+videoName;
	var popup = window.open(url, "_blank", "location=no,height=450,width=650,scrollbars=no,status=no, menubar=no, titlebar=no, toolbar=no");
}

function uploadMiniatura() {
	var uploadMiniatura = $('#file-upload-miniatura').val();
	uploadMiniatura = uploadMiniatura.replace(/.*(\/|\\)(.*)/, '$2');
	$("#hrjpeg").val(uploadMiniatura);
}
function uploadGrande() {
	var uploadGrande = $('#file-upload-grande').val();
	uploadGrande = uploadGrande.replace(/.*(\/|\\)(.*)/, '$2');
	$("#cuadro").val(uploadGrande);
}
function uploadVideo() {
	var uploadVideo = $('#file-upload-video').val();
	uploadVideo = uploadVideo.replace(/.*(\/|\\)(.*)/, '$2');
	$("#video").val(uploadVideo);
}
function uploadImagen() {
	var uploadImagen = $('#file-upload-imagen').val();
	uploadImagen = uploadImagen.replace(/.*(\/|\\)(.*)/, '$2');
	$("#imagen").val(uploadImagen);
}