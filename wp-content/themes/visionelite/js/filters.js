jQuery(document).ready(function($){

    // Normalize to array
    function normalizeToArray(value) {
        if (Array.isArray(value)) {
            return value.map(i => String(i).trim()); // cast all items to string
        }
        if (typeof value === 'string') {
            try {
                let parsed = JSON.parse(value);
                if (Array.isArray(parsed)) return parsed.map(i => String(i).trim());
            } catch (e) {
                // not JSON, treat as CSV
                return value.split(',').map(i => i.trim());
            }
        }
        return [String(value).trim()]; // catch-all
    }

    function filterSessions() {
		var programFilter  = $('#filter-programs').val()  || "all";
		var sportFilter    = $('#filter-sport').val()     || "all";
		var seasonFilter   = $('#filter-season').val()    || "all";
		var provinceFilter = $('#filter-province').val()  || "all";
		var cityFilter     = $('#filter-city').val()      || "all";
		var ageFilter      = $('#filter-age').val()       || "all";
		var gradeFilter    = $('#filter-grade').val()     || "all";
		var genderFilter   = $('#filter-gender').val()    || "all";
        var skillLevelFilter = $('#filter-skill_level').val() || "all";

		console.log('--- FILTER VALUES ---');
		console.log({
		  programFilter,
		  sportFilter,
		  seasonFilter,
		  provinceFilter,
		  cityFilter,
		  ageFilter,
		  gradeFilter,
		  genderFilter,
          skillLevelFilter
		});

        $('#sessions li.session').each(function() {
            var $session = $(this);
            var program = $session.data('program');
            var sport = $session.data('sport');
            var season = $session.data('season');
            var province = $session.data('province');
            var city = $session.data('city');
            var ages = normalizeToArray($session.data('ages'));
            var grade = normalizeToArray($session.data('grade'));
            var gender = $session.data('gender');
            var skillLevel = $session.data('skill');

            var show = true;

            if (programFilter !== 'all' && program !== programFilter) {
                show = false;
            }
            if (sportFilter !== 'all' && sport !== sportFilter) {
                show = false;
            }
            if (seasonFilter !== 'all' && season !== seasonFilter) {
                show = false;
            }
            if (provinceFilter !== 'all' && province !== provinceFilter) {
                show = false;
            }
            if (cityFilter !== 'all' && city !== cityFilter) {
                show = false;
            }
            if (ageFilter !== 'all' && !ages.includes(ageFilter)) {
                show = false;
            }
            if (gradeFilter !== 'all' && !grade.includes(gradeFilter)) {
                show = false;
            }
            if (genderFilter !== 'all' && (gender !== genderFilter && gender !== 'CO-ED')) {
                show = false;
            }
            if (skillLevelFilter !== 'all' && !skillLevel.includes(skillLevelFilter)) {
                show = false;
            }

            if (show) {
                $session.show();
            } else {
                $session.hide();
            }
/*
console.log('--- SESSION DATA ---');
console.log({
  program,
  sport,
  season,
  province,
  city,
  ages,
  grade,
  gender
});
*/
        });
    }
    // Trigger filtering when any filter changes
    $('#filter-programs, #filter-sport, #filter-season, #filter-province, #filter-city, #filter-age, #filter-gender, #filter-grade, #filter-skill_level').on('change', function() {
        filterSessions();
    });
    // Initial filter in case page loads with selected options
     filterSessions();

    // toggle showing the #filters div
    $('#toggle-filters').on('click', function() {
        const $icon = $(this).find('i');
        if ($icon.hasClass('fa-filter')) {
            $icon.removeClass('fa-filter').addClass('fa-times');
            $('#filters').addClass('show');
        }
        else {
            $icon.removeClass('fa-times').addClass('fa-filter');
            $('#filters').removeClass('show');
        }
    });
    
    // if any filter is not set to 'all', show the filters div
    if ($('#filter-programs').val() !== 'all' ||
        $('#filter-sport').val() !== 'all' ||
        $('#filter-season').val() !== 'all' ||
        $('#filter-province').val() !== 'all' ||
        $('#filter-city').val() !== 'all' ||
        $('#filter-age').val() !== 'all' ||
        $('#filter-grade').val() !== 'all' ||
        $('#filter-gender').val() !== 'all' ||
        $('#filter-skill_level').val() !== 'all') {
        $('#toggle-filters i').removeClass('fa-filter').addClass('fa-times');
        $('#filters').addClass('show');
    }
});

// Cookie management for filter selections
document.addEventListener("DOMContentLoaded", function () {
    // if #filters doesn't exist, return
    if (!document.getElementById('filters')) {
        return;
    }
    
    const filterIds = [
        "filter-programs",
        "filter-sport",
        "filter-season",
        "filter-province",
        "filter-city",
        "filter-age",
        "filter-grade",
        "filter-gender",
        "filter-skill_level"
    ];

    // Load saved cookies
    filterIds.forEach(id => {
        const select = document.getElementById(id);
        const cookieValue = getCookie(id);
        if (select && cookieValue) {
            select.value = cookieValue;
        }

        // Save selection to cookie on change
        select.addEventListener('change', function () {
            setCookie(id, this.value, 30); // save for 30 days
        });
    });

    // Cookie helper functions
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days*24*60*60*1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
        return null;
    }
});