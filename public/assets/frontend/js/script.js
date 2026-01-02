$(document).ready(function () {
    $('#userProfile').on('click', function (e) {
        e.stopPropagation()
        $('.dropdown-menu').not($(this).find('.dropdown-menu')).slideUp(150)
        $(this).find('.dropdown-menu').stop(true, true).slideToggle(150)
    })

    $(document).on('click', function () {
        $('.dropdown-menu').slideUp(150)
    })
})

// For Sidebar
$(document).ready(function () {
    const $siteLogo = $('#site-logo');
    const $sidebar = $('#sidebar');
    const $toggleBtnBox = $('.toggleBtnBox');
    const $toggleBtn = $('#sidebarToggle');
    const $sidebarTitle = $('.sidebar-title');
    const $iconOpen = $('#icon-open');
    const $iconFolded = $('#icon-folded');
    const $mainContent = $('#mainContent');
    const $mobileMenu = $('#mobileMenu');
    const $navContainer = $('#nav-container');

    let folded = false;
    let hoverActive = false;

    function foldSidebar() {
        folded = true;
        $sidebar.addClass('sidebar-folded');
        $siteLogo.hide();
        $iconOpen.hide();
        $iconFolded.show();
        $mainContent.css('margin-left', '4rem');
        $toggleBtnBox.css('justify-content', 'center');
        $sidebarTitle.hide();
        $navContainer.css('margin-left', '4rem').css('width', 'calc(100% - 4rem)');
        $(window).trigger('resize');
    }

    function unfoldSidebar() {
        folded = false;
        $sidebar.removeClass('sidebar-folded');
        $siteLogo.show();
        $iconOpen.show();
        $iconFolded.hide();
        $mainContent.css('margin-left', '15rem');
        $toggleBtnBox.css('justify-content', 'space-between');
        $sidebarTitle.show();
        $navContainer.css('margin-left', '15rem').css('width', 'calc(100% - 15rem)');
        $(window).trigger('resize');
    }

    // Hover behavior for desktop
    function tempUnfold() {
        if (folded && !hoverActive && $(window).width() > 768) {
            hoverActive = true;
            $sidebar.removeClass('sidebar-folded');
            $siteLogo.show();
            $toggleBtnBox.css('justify-content', 'space-between');
            $sidebarTitle.show();
        }
    }

    function tempFold() {
        if (folded && hoverActive && $(window).width() > 768) {
            hoverActive = false;
            $sidebar.addClass('sidebar-folded');
            $siteLogo.hide();
            $toggleBtnBox.css('justify-content', 'center');
            $sidebarTitle.hide();
        }
    }

    // Toggle button click
    $toggleBtn.on('click', function () {
        if (folded) {
            unfoldSidebar();
        } else {
            foldSidebar();
        }
    });

    // Hover only on large screens
    $sidebar.on('mouseenter', tempUnfold);
    $sidebar.on('mouseleave', tempFold);

    // Mobile menu
    $mobileMenu.on('click', function () {
        $sidebar.toggleClass('-translate-x-full');
    });

    // Reset on resize
    $(window).on('resize', function () {
        if ($(window).width() > 768) {
            $sidebar.removeClass('-translate-x-full');
        }
    });
});


// For Navbar
$(document).ready(function () {
    $('#menuToggle, #overlay').click(function () {
        $('#sidebar').toggleClass('active');
        $('#overlay').toggleClass('active');
    });

    $('.nav-item').click(function () {
        $('.nav-item').removeClass('active');
        $(this).addClass('active');
    });

    // Close sidebar on window resize if window becomes larger
    $(window).resize(function () {
        if ($(window).width() > 768) {
            $('#sidebar').removeClass('active');
            $('#overlay').removeClass('active');
        }
    });
});


// For Slider
$(function () {
    let current = 0;
    let autoPlay;
    const $wrap = $('#sliderWrapper');
    const $slides = $('.slide');
    const total = $slides.length;

    // Create dots
    const $dots = Array.from({ length: total }, (_, i) => $('<div class="dot">').appendTo('#dotsContainer'));

    const update = () => {
        $wrap.css('transform', `translateX(-${current * 100}%)`);
        $('.dot').removeClass('active').eq(current).addClass('active');
    };

    const move = dir => {
        current = (current + dir + total) % total;
        update();
    };

    const go = i => {
        current = i;
        update();
    };

    // Buttons
    $('#prevBtn').on('click', () => move(-1));
    $('#nextBtn').on('click', () => move(1));

    // Dots
    $('#dotsContainer').on('click', '.dot', e => go($(e.target).index()));

    // Auto play
    const start = () => autoPlay = setInterval(() => move(1), 4000);
    const stop = () => clearInterval(autoPlay);
    $('.slider-container').hover(stop, start);

    // Keyboard arrows
    $(document).on('keydown', e => {
        if (e.key === 'ArrowLeft') move(-1);
        if (e.key === 'ArrowRight') move(1);
    });

    // Initialize
    update();
    start();
});


// Poster Slider
document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.poster-swiper', {
        slidesPerView: 5.5,       // How many slides are visible at once
        slidesPerGroup: 5,         // How many slides to scroll at a time
        spaceBetween: 14,          // Gap between slides
        speed: 800,
        navigation: {
            nextEl: '.poster-nav.next',
            prevEl: '.poster-nav.prev',
        },
        grabCursor: true,
        observer: true,
        observeParents: true,
        loop: false,               // Keep false if you don’t want infinite looping
    });
});



$(document).ready(function () {
    const videoSection = $('.video-section')[0];
    const video = $('#mainVideo').get(0);
    if (!video) return;
    const videoLength = video.duration;
    const ctrlPlay = $('#playIcon');
    const ctrlPause = $('#pauseIcon');
    const progressBar = $('#progressBar');
    const progressFill = $('#progressFill');
    const progressTooltip = $('#progressTooltip');
    const videoDuration = $('.video-duration');
    const currentime = $('.current-time');
    const controles = $('#videoControlsOverlay');
    const settingBtn = $('#settingBtn');
    const settingsDropdown = $('#settingsDropdown');
    const volumeRange = $('#volumeRange');
    const volumeBtn = $('#volumeBtn');
    const volumeIcon = $('#volumeBtn i');
    const expandBtn = $('#expand-btn');
    const progressBarWidth = progressBar.width();
    let wasPlaying = false;
    let isDragging = false;
    let timeout;
    
    init();
    function init(){
        videoDuration.text(durationConverter(videoLength));
        video.volume = 1.0;
    }

    function durationConverter(videoLength) {
        if (isNaN(videoLength) || videoLength < 0) return '0:00';

        let hours = Math.floor(videoLength / 3600);
        let minutes = Math.floor((videoLength % 3600) / 60);
        let seconds = Math.floor(videoLength % 60);

        if (hours > 0) {
            return `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        } else {
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
    }

    function playVideo () {
        video.play();
        ctrlPlay.addClass('d-none');
        ctrlPause.removeClass('d-none');
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            hideControles();
        }, 3200);
    }

    function pauseVideo () {
        video.pause();
        ctrlPause.addClass('d-none');
        ctrlPlay.removeClass('d-none');
        showControles();
    }

    function showControles(){
        $('#mainVideo').css('cursor', 'auto');
        controles.css('opacity', '1').css('cursor', 'auto');
    }

    function hideControles(){
        if (!$('#mainVideo').paused){
            $('#mainVideo').css('cursor', 'none');
            controles.css('opacity', '0').css('cursor', 'none');
        }   
    }

    function fullScreen(){
        if (!document.fullscreenElement) {
            if (videoSection.requestFullscreen) {
                videoSection.requestFullscreen();
            } else if (videoSection.webkitRequestFullscreen) {
                videoSection.webkitRequestFullscreen();
            } else if (videoSection.msRequestFullscreen) {
                videoSection.msRequestFullscreen();
            }
            expandBtn.addClass('fa-compress').removeClass('fa-expand');
            $('.video-player').css('border-radius', '0px')
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            expandBtn.addClass('fa-expand').removeClass('fa-compress');
            $('.video-player').css('border-radius', '5px')
        }
    }

    function updateInfo () {
        const currentTime = video.currentTime;
        const progressPercentage = (currentTime / videoLength) * 100;
        progressFill.css('width', `${progressPercentage}%`);
        currentime.text(durationConverter(currentTime));
    }

    function updateProgress(e) {
        let offsetX = e.pageX - progressBar.offset().left;

        if (offsetX < 0) offsetX = 0;
        if (offsetX > progressBarWidth) offsetX = progressBarWidth;

        let newTime = (offsetX / progressBarWidth) * video.duration;

        progressTooltip.css({
            left: offsetX + 'px',
            opacity: 1,
            transform: 'translateX(-50%) translateY(-5px)'
        }).text(durationConverter(newTime));

        progressFill.css('width', (offsetX / progressBarWidth * 100) + '%');

        $('.current-time').text(durationConverter(newTime));
    }

    ctrlPlay.on('click', function () {
        playVideo();
    });

    ctrlPause.on('click', function () {
        pauseVideo();
    });

    $('#mainVideo').on('click', function () {
        this.paused ? playVideo() : pauseVideo();
    });

    expandBtn.on('click', function () {
        fullScreen();
    });

    $('#mainVideo').on('timeupdate', function () {
        updateInfo();
    });

    $('#mainVideo, #videoControlsOverlay').on('mousemove', function () {
        showControles();
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            hideControles();
        }, 3200);
    });

    progressBar.on('click', function (e) {
        let clickX = e.offsetX;

        let newTime = (clickX / progressBarWidth) * videoLength;
        video.currentTime = newTime;

        let newWidth = (clickX / progressBarWidth) * 100;
        progressFill.css('width', `${newWidth}%`);
    });

    progressBar.on('mousemove', function (e) {
        const offsetX = e.offsetX;
        const percent = offsetX / progressBarWidth;
        const hoverTime = video.duration * percent;

        progressTooltip.css({
            left: offsetX + 'px',
            opacity: 1,
            transform: 'translateX(-50%) translateY(-3px)'
        });

        progressTooltip.text(durationConverter(hoverTime));
    });

    progressBar.on('mouseleave', function () {
        progressTooltip.css({
            opacity: 0,
            transform: 'translateX(-50%) translateY(0)'
        });
    });

    progressBar.on('mousedown', function (e) {
        isDragging = true;
        wasPlaying = !video.paused;
        video.pause();

        $('#progressFill').css('transition', 'none');

        updateProgress(e);
    });

    $(document).on('mousemove', function (e) {
        if (isDragging) {
            updateProgress(e);
        }
    });

    $(document).on('mouseup', function (e) {
        if (isDragging) {
            isDragging = false;

            let offsetX = e.pageX - progressBar.offset().left;

            if (offsetX < 0) offsetX = 0;
            if (offsetX > progressBarWidth) offsetX = progressBarWidth;

            let newTime = (offsetX / progressBarWidth) * video.duration;
            video.currentTime = newTime;

            $('#progressTooltip').css({
                opacity: 0,
                transform: 'translateX(-50%) translateY(0)'
            });

            $('#progressFill').css('transition', 'width 0.3s');

            if (wasPlaying) {
                video.play();
            }
        }
    });

    $(document).on('fullscreenchange webkitfullscreenchange msfullscreenchange', function () {
        if (!document.fullscreenElement &&
            !document.webkitFullscreenElement &&
            !document.msFullscreenElement) {
            // Exited fullscreen → show expand icon
            expandBtn.addClass('fa-expand').removeClass('fa-compress');
            $('.video-player').css('border-radius', '5px');
        } else {
            // Entered fullscreen → show compress icon
            expandBtn.addClass('fa-compress').removeClass('fa-expand');
        }
    });

    video.addEventListener('ended', function () {   
        ctrlPause.addClass('d-none');
        ctrlPlay.removeClass('d-none');
    });

    volumeRange.on('input', function () {
        const volumeValue = $(this).val() / 100;
        video.volume = volumeValue;

        if (video.muted || volumeValue === 0) {
            volumeIcon.removeClass().addClass('fa-solid fa-volume-xmark');
        } else if (volumeValue > 0 && volumeValue <= 0.5) {
            volumeIcon.removeClass().addClass('fa-solid fa-volume-low');
        } else {
            volumeIcon.removeClass().addClass('fa-solid fa-volume-high');
        }

        if (video.muted && volumeValue > 0) {
            video.muted = false;
        }
    });

    volumeBtn.on('click', function () {
        video.muted = !video.muted;

        if (video.muted) {
            volumeIcon.removeClass().addClass('fa-solid fa-volume-xmark');
            volumeRange.val(0);
        } else {
            const currentVolume = video.volume * 100;
            volumeRange.val(currentVolume);
            if (video.volume === 0) {
                volumeIcon.removeClass().addClass('fa-solid fa-volume-xmark');
            } else if (video.volume > 0 && video.volume <= 0.5) {
                volumeIcon.removeClass().addClass('fa-solid fa-volume-low');
            } else {
                volumeIcon.removeClass().addClass('fa-solid fa-volume-high');
            }
        }
    });

    settingBtn.on('click', function (e) {
        e.stopPropagation();
        settingsDropdown.toggleClass('show');
    });


    $(document).on('click', function (e) {
        if (!$(e.target).closest('.settings-container').length) {
            settingsDropdown.removeClass('show');
        }
    });
});
