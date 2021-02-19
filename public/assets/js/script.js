console.log('%c Zeus. For Lazy Programmer ', 'background: #222; color: #bada55; font-size:40px');

function overlay_show() {
    $(".m-overlay").show()
}

function overlay_hide() {
    setTimeout(function () {
        $(".m-overlay").hide()
    }, 500)
}

function toast_show(title,message)
{
    iziToast.show({
        title: title,
        message: message,
        theme: 'dark',
        progressBarColor: '#d48d37',
        icon: 'icon-chat_bubble',
        position: 'topRight',
        displayMode: 2,
        timeout:2000,
        progressBar:false
    });
}
