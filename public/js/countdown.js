var Countdown = {
    format: {
        home: '{days}:{hours}:{minutes}:{seconds}',
        dashboard: '{days} hari {hours} jam {minutes} menit {seconds} detik'
    },
    doCountdown: function (format, tagId, time, doReload = true, doneCallback = null) {
        var x = setInterval(function () {
            var now = new Date().getTime();

            var distance = time - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            days = (parseInt(days / 10) == 0) ? "0" + days : days;
            hours = (parseInt(hours / 10) == 0) ? "0" + hours : hours;
            minutes = (parseInt(minutes / 10) == 0) ? "0" + minutes : minutes;
            seconds = (parseInt(seconds / 10) == 0) ? "0" + seconds : seconds;

            output = format.replace('{days}', days);
            output = output.replace('{hours}', hours);
            output = output.replace('{minutes}', minutes);
            output = output.replace('{seconds}', seconds);
            document.getElementById(tagId).innerHTML = output;

            if (distance <= 0) {
                output = format.replace('{days}', '00');
                output = output.replace('{hours}', '00');
                output = output.replace('{minutes}', '00');
                output = output.replace('{seconds}', '00');
                document.getElementById(tagId).innerHTML = output;
                clearInterval(x);
                if (doReload)
                    location.reload();
                if (doneCallback !== null)
                    doneCallback();
            }
        }, 1000);

        return x;
    }
};