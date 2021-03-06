/*!
 * VeganCheck.me app.js
 * https://vegancheck.me
 * https://isitvegan.io
 * Git-Repo: https://vegc.net/repo
 *
 * Includes JavaScript Only Barcode_Reader (JOB) by Eddie Larsson
 * https://github.com/EddieLa/BarcodeReader
 *
 * Copyright JokeNetwork and contributors
 * Released under the MIT license
 * https://vegc.net/license
 *
 */

function setupLiveReader(resultElement) {
    // Scroll to top
    window.location.hash = '#top';

    // Create scanner-container
    var container = document.createElement('div')
    container.className = 'eanscanner'
    container.style.position = 'absolute'
    container.style.zIndex = '999'
    container.style.width = '100%'
    container.style.height = '100%'
    container.style.left = '0'
    container.style.top = '0'
    var canvas = document.createElement('canvas')
    var video = document.createElement('video')
    var context = canvas.getContext('2d')
    canvas.style.position = 'absolute'
    container.appendChild(canvas)
    document.body.insertBefore(container, resultElement)

    // Define camera facingMode once
    camera = 'environment'
    
    // Flip camera button
    document.getElementById('flipbutton').onclick = function() {
        if (camera == 'environment'){
            camera = 'user'
        }
        else if(camera == 'user'){
            camera = 'environment'
        }
        else{
            camera = 'environment'
        }

        // End stream and restart
        initendStream();
        startStream();
    };

    // Start the stream
    startStream();

function startStream(){
    document.getElementById('result').style.display = 'none';

    // Scroll to top
    window.location.hash = '#top';

    // Check for the facingMode
     if (camera == 'environment' || camera == 'user'){
        var constraints = { audio: false, video: { width: window.innerWidth * window.devicePixelRatio,
    height: window.innerHeight * window.devicePixelRatio, aspectRatio: { ideal: (window.innerHeight) / window.innerWidth }, focusMode: 'continuous', facingMode: camera } };
    }
    else {
        camera = 'environment'
        var constraints = { audio: false, video: { width: window.innerWidth * window.devicePixelRatio,
    height: window.innerHeight * window.devicePixelRatio, aspectRatio: { ideal: (window.innerHeight) / window.innerWidth }, focusMode: 'continuous', facingMode: camera } };
    }

    navigator.mediaDevices.getUserMedia(constraints).then(stream => {
        const track = stream.getVideoTracks()[0];
        BarcodeScanner.init()
        var closer = document.getElementById('controls')
        var btnclose = document.getElementById('closebtn')
        var barcodeicon = document.getElementById('barcodeicon')
        closer.style.display = 'inline-block'

        // Torch/Flash on Android
        const btn = document.getElementById('torch');
        btn.addEventListener('click', function(){
          track.applyConstraints({
            advanced: [{torch: true}]
          });
      })

        function endStream(){
            track.stop();
        }
        initendStream = endStream;


        // When barcode is detected
        BarcodeScanner.streamCallback = function(result) {
            document.getElementById('barcode').value = result[0].Value
            barcodeicon.style.color = "#10ac84";
            barcodeicon.style.opacity = "1";
            setTimeout(function() {
                BarcodeScanner.StopStreamDecode()
                video.pause()
                stream.getTracks()[0].stop()
                container.classList.add('fadeOut')
                closer.classList.add('fadeOut')
                barcodeicon.style.color = "#fff";
                barcodeicon.style.opacity = "0.4";
                }, 300);
            setTimeout(function() {
                container.classList.remove('fadeOut')
                closer.classList.remove('fadeOut')
                container.style.display = 'none'
                closer.style.display = 'none'
            }, 500);

            // Auto submit barcode
            document.getElementsByTagName('button')[0].click();
        }

        // Close stream when button is clicked
        btnclose.onclick = function(close) {
            BarcodeScanner.StopStreamDecode()
            video.pause()
            stream.getTracks()[0].stop()
            container.classList.add('fadeOut')
            closer.classList.add('fadeOut')
            setTimeout(function() {
                container.classList.remove('fadeOut')
                closer.classList.remove('fadeOut')
                container.style.display = 'none'
                closer.style.display = 'none'
            }, 1000);
        }

        video.setAttribute('autoplay', '')
        video.setAttribute('playsinline', '')
        video.setAttribute('style', 'width: 100%; height: 100%;')
        video.srcObject = stream

        container.appendChild(video)
        video.onloadedmetadata = function(e) {
            video.play()
            BarcodeScanner.DecodeStream(video)
        }
        }).catch(function(err) {})
    }
document.getElementById('result').style.display = 'block';
}

// Close modal on escape-key press
$(document).on('keyup', function(e) {
    if (e.key == "Escape") $('.modal_close').click();
    if (e.key == "Escape") $('#closebtn').click();
});

// submit.js
$('button[name="submit"]').on('click', function(e) {
    e.preventDefault();
    $(".timeout-final").css("display","none");
    $.ajax({
        url: '../script.php',
        type: 'POST',
        timeout: 8000,
        data: {
            barcode: $('input[name="barcode"]').val(),
            lang: $('input[name="lang"]').val()
        },
        error: function(){
          $(".timeout").css("display","none");
          $(".timeout-final").css("display","block");
        },
        success: function(result) {
            $('#result').html(result);
            $('html, body').animate({
                scrollTop: $('#resscroll').offset().top
            }, 900, 'swing');

            // Scroll to result
            self.location.href = '#resscroll';

            $(document).on('click', function(){
                $(".container").removeClass('modalIsOpen')
                $(".modal_view").addClass('fadeOut')
                setTimeout(function() {
                    $(".modal_view").css("display","none")
                    $(".modal_view").removeClass('fadeOut')
                    $(".modal_view").addClass('fadeIn')
                }, 500);
            });
            $(".modal_view").on('click', function(event){
                event.stopPropagation();
            });

            $('#nutri_modal').click(function(){
                $("#nutriscore").css("display","block")
                $(".container").addClass('modalIsOpen')
                event.stopPropagation();
            });
            $('.modal_close').click(function(){
                $("#nutriscore").addClass('fadeOut')
                $(".container").removeClass('modalIsOpen')
                setTimeout(function() {
                    $("#nutriscore").css("display","none")
                    $("#nutriscore").removeClass('fadeOut')
                    $("#nutriscore").addClass('fadeIn')
                }, 500);
            });
            $('#palm_modal').click(function(){
                $("#palmoil").css("display","block")
                $(".container").addClass('modalIsOpen')
                event.stopPropagation();
            });
            $('.modal_close').click(function(){
                $("#palmoil").addClass('fadeOut')
                $(".container").removeClass('modalIsOpen')
                setTimeout(function() {
                    $("#palmoil").removeClass('fadeOut')
                    $("#palmoil").addClass('fadeIn')
                    $("#palmoil").css("display","none")

                }, 500);
            });
            $('#processed_modal').click(function(){
                $("#processed").css("display","block")
                $(".container").addClass('modalIsOpen')
                event.stopPropagation();
            });
            $('.modal_close').click(function(){
                $("#processed").addClass('fadeOut')
                $(".container").removeClass('modalIsOpen')
                setTimeout(function() {
                    $("#processed").removeClass('fadeOut')
                    $("#processed").addClass('fadeIn')
                    $("#processed").css("display","none")

                }, 500);
            });
            $('#license_modal').click(function(){
                $("#license").css("display","block")
                $(".container").addClass('modalIsOpen')
                event.stopPropagation();
            });
            $('.modal_close').click(function(){
                $("#license").addClass('fadeOut')
                $(".container").removeClass('modalIsOpen')
                setTimeout(function() {
                    $("#license").removeClass('fadeOut')
                    $("#license").addClass('fadeIn')
                    $("#license").css("display","none")

                }, 500);
            });
        }
    });
});

// Initialize SW
if ('serviceWorker' in navigator) { navigator.serviceWorker.register('../sw.js'); }

// Spinner while AJAX request
var $loading = $('#spinner').hide();
$(document)
    .ajaxStart(function() {
        $('.logo').addClass('spinner');
    })
    .ajaxStop(function() {
        $('.logo').removeClass('spinner');
    });

// "Timeout"-Warning
var ajaxLoadTimeout;
$(document).ajaxStart(function() {
    ajaxLoadTimeout = setTimeout(function() { 
        $(".timeout").css("display","block");
    }, 1500);

}).ajaxSuccess(function() {
    clearTimeout(ajaxLoadTimeout);
    $(".timeout").css("display","none");
});

// Check if user is offline
window.addEventListener('offline', function(e) { window.location.href = "/offline"; });

// Share button init
function sharebutton()
{
    const title = document.title;
    const text = document.getElementById('name_sh').innerHTML + " " + document.getElementById('result_sh').innerHTML + " - Checked using VeganCheck";
    const url = "https://vegancheck.me"

    if (navigator.share !== undefined) {
            navigator.share({
                title,
                text,
                url
            })
            .catch(err => "");
    } else {
      window.location = `https://twitter.com/intent/tweet?url=https://vegancheck.me&text=${encodeURI(text)}`;
    }

} 