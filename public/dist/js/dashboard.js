$(document).ready(function(){
    //DATE FILTERS
    var day = moment().endOf('day'),
        onSelectBtn,
        today = moment(new Date()),
        fweekday = moment(today).startOf('isoWeek').add(1, 'days'),
        leekday = moment(today).endOf('isoWeek'),
        fmonthday = moment(today).startOf('month').add(1, 'days'),
        lmonthday = moment(today).endOf('month');
        if(lmonthday >= today){
            lmonthday = today;
        }

        if(leekday >= today){
            leekday = today;
        }
    
    $('.date').text(moment.utc(fmonthday).format('MM/DD/YYYY') + ' - ' + moment.utc(lmonthday).format('MM/DD/YYYY'));
    if(day >= today){
        $('.fa-angle-right.arrow-next').attr('disabled',true);
    }

    $('.btn.btn-1').on('click',function(){
        day = moment().endOf('day');
        today = moment(new Date());
        $('.date').text(moment.utc(today).format('MM/DD/YYYY'));
        if(day >= today){
            $('.fa-angle-right.arrow-next').attr('disabled',true);
        }
    });

    $('.btn.btn-2').on('click',function(){
        day = moment().endOf('day');
        today = moment(new Date());
        fweekday = moment(today).startOf('isoWeek').add(1, 'days');
        leekday = moment(today).endOf('isoWeek');
        if(leekday >= today){
            leekday = today;
        }
        $('.date').text(moment.utc(fweekday).format('MM/DD/YYYY') + ' - ' + moment.utc(leekday).format('MM/DD/YYYY'));
        if(leekday >= today){
            $('.fa-angle-right.arrow-next').attr('disabled',true);
        }
    });

    $('.btn.btn-3').on('click',function(){
        day = moment().endOf('day');
        today = moment(new Date());
        fmonthday=moment(today).startOf('months').add(1, 'days');
        lmonthday=moment(today).endOf('months');
        if(lmonthday >= today){
            lmonthday = today;
        }
        $('.date').text(moment.utc(fmonthday).format('MM/DD/YYYY') + ' - ' + moment.utc(lmonthday).format('MM/DD/YYYY'));
        if(lmonthday >= today){
            $('.fa-angle-right.arrow-next').attr('disabled',true);
        }
    });

    $('.arrow.arrow-prev').on('click',function(){
        onSelectBtn = $('.btn.active').attr('value');
        if(onSelectBtn == 'Day'){
            day = moment(day).subtract(1, 'days');
            $('.date').text(moment.utc(day).format('MM/DD/YYYY'));
            if(day <= today){
                $('.fa-angle-right.arrow-next').attr('disabled',false);
            }
        }else if(onSelectBtn == 'Week'){
            fweekday = moment(day).subtract(1, 'weeks').startOf('isoWeek').add(1, 'days');
            leekday = moment(day).subtract(1, 'weeks').endOf('isoWeek');
            day = moment(day).subtract(1, 'weeks');
            
            $('.date').text(moment.utc(fweekday).format('MM/DD/YYYY') + ' - ' + moment.utc(leekday).format('MM/DD/YYYY'));
            if(leekday <= moment(today).endOf('isoWeek')){
                $('.fa-angle-right.arrow-next').attr('disabled',false);
            }
        }else{
            fmonthday = moment(day).subtract(1, 'months').startOf('month').add(1, 'days');
            lmonthday = moment(day).subtract(1, 'months').endOf('month');
            day = moment(day).subtract(1, 'months');
            $('.date').text(moment.utc(fmonthday).format('MM/DD/YYYY') + ' - ' + moment.utc(lmonthday).format('MM/DD/YYYY'));
            if(lmonthday <= moment(today).endOf('month')){
                $('.fa-angle-right.arrow-next').attr('disabled',false);
            }
        }
    });

    $('.arrow.arrow-next').on('click',function(){
        onSelectBtn = $('.btn.active').attr('value');
        if(onSelectBtn == 'Day'){
            day = moment(day).add(1, 'days');
            $('.date').text(moment.utc(day).format('MM/DD/YYYY'));
            if(day >= today){
                $('.fa-angle-right.arrow-next').attr('disabled',true);
            }
        }else if(onSelectBtn == 'Week'){
            fweekday = moment(day).add(1, 'weeks').startOf('isoWeek').add(1, 'days');
            leekday = moment(day).add(1, 'weeks').endOf('isoWeek');
            day = moment(day).add(1, 'weeks');
            if(leekday >= today){
                leekday = today;
            }
            $('.date').text(moment.utc(fweekday).format('MM/DD/YYYY') + ' - ' + moment.utc(leekday).format('MM/DD/YYYY'));
            if(leekday >= today){
                $('.fa-angle-right.arrow-next').attr('disabled',true);
            }
        }else{
            fmonthday = moment(day).add(1, 'months').startOf('month').add(1, 'days');
            lmonthday = moment(day).add(1, 'months').endOf('month');
            day = moment(day).add(1, 'months');
            if(lmonthday >= today){
                lmonthday = today;
            }
            $('.date').text(moment.utc(fmonthday).format('MM/DD/YYYY') + ' - ' + moment.utc(lmonthday).format('MM/DD/YYYY'));
            if(lmonthday >= today){
                $('.fa-angle-right.arrow-next').attr('disabled',true);
            }
        }
    });

    $(".arrow").click(function () {
        $('.date').trigger('contentchanged');
    });

    $(".btn").click(function () {
        $('.date').trigger('contentchanged');
    });

    var dataFormat = function(f,d,type,active){
        var data = [['Day', type,active]];
        if (d.length > 0) {
            d.forEach(e => {
                ele = [e.date,e.total,e.active];
                data.push(ele);
            });
        } else {
            ele = [f,0,0];
            data.push(ele);
        }
        
        return data;
    }

    var timer = null;
    $('.date').bind('contentchanged', function() {
        timer = setTimeout(function() {
            timer = null;
            var day_from,
                day_to,
                day_start,
                type = $('.btn.active').attr('value');
            if(type == 'Day'){
                day_to = moment(day).format('YYYY-MM-DD');
                day_from = moment(day).subtract(6, 'days').format('YYYY-MM-DD');
                day_start = day_to;
            }else if(type == 'Week'){
                day_from = moment(day).subtract(6, 'weeks').startOf('isoweek').format('YYYY-MM-DD');
                day_to = moment(leekday).format('YYYY-MM-DD');
                day_start =  moment(day).startOf('isoWeek').format('YYYY-MM-DD');
            }else{
                day_from = moment(day).subtract(6, 'months').startOf('month').format('YYYY-MM-DD');
                day_to = moment(lmonthday).format('YYYY-MM-DD');
                day_start = moment(day).startOf('month').format('YYYY-MM-DD');
            }
            ajaxCharts(type,day_from,day_to);
            ajaxStatistics(day_start,day_to);
        }, 80);
    });

    var ajaxCharts = function(type,day_from,day_to){
        $.ajax({
            url: "/admin/charts/data",
            type: 'POST',
            data: { 'type': type,'day_from': day_from,'day_to': day_to },
            beforeSend: function() {
                $("#loaderDiv").show();
            },
            success: function( msg ) {
                $("#loaderDiv").hide();
                drawChart(dataFormat(day_from,msg[0]['items'],jsLang.total_items,jsLang.active_items),dataFormat(day_from,msg[0]['accounts'],jsLang.total_accounts,jsLang.active_accounts));
            },
            error: function(){
                alert(jsLang.error_msg);
                $("#loaderDiv").hide();
            },
        });
    }

    var ajaxStatistics = function(day_start,day_to){
        $.ajax({
            url: "/admin/charts/statistics",
            type: 'GET',
            data: { 'day_start': day_start,'day_to': day_to },
            beforeSend: function() {
                $("#loaderDiv").show();
            },
            success: function( msg ) {
                $("#loaderDiv").hide();
                $('.statistics').html(msg);
            },
            error: function(){
                alert(jsLang.error_msg);
                $("#loaderDiv").hide();
            },
        });
    }
    
    //CHARTS
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    $(window).on('load',function(){
        ajaxCharts('Month',moment(day).subtract(6, 'months').startOf('month').format('YYYY-MM-DD'),moment(lmonthday).format('YYYY-MM-DD'));
        ajaxStatistics(moment(day).startOf('month').format('YYYY-MM-DD'),moment(lmonthday).format('YYYY-MM-DD'));
    });

    function drawChart(items,accounts) {
        var item = google.visualization.arrayToDataTable(
            items
        );

        var account = google.visualization.arrayToDataTable(
            accounts
        );

        var itemOptions = {
            boxStyle: {
                strokeWidth: 2,
            },
            vAxis: {minValue: 0},
            legend: {position: 'bottom', maxLines: 2},
        };

        var accountOptions = {
            vAxis: {minValue: 0},
            legend: {position: 'bottom', maxLines: 2},
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(item, itemOptions);
        var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        chart.draw(account, accountOptions);
    }
    
  });