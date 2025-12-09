// App Builder Video Functions 

function playOnlineVideo(id, url) {
   var el = document.getElementById(id);
   var htmlVideo = "<iframe src=\"" + url + "\" " +
               "frameborder=\"0\" " +
               "webkitallowfullscreen mozallowfullscreen allowfullscreen allow=\"autoplay\">";
   el.innerHTML = htmlVideo;
}

function playVideoFile(id, filename) {
   var el = document.getElementById(id);
   var htmlVideo = "<video controls autoplay>";
   htmlVideo = htmlVideo + "<source src=\"" + filename + "\" type=\"video/mp4\">";
   htmlVideo = htmlVideo + "</video>";
   el.innerHTML = htmlVideo;
}
