<?php

class DateTimeUi
{
    private static $registerOnce = false;

    public static function renderDate($name, $key, $value)
    {
        if (empty($value)) {
            $value = time();
        }
        $day = date('j', $value);
        $month = date('n', $value);
        $year = date('Y', $value);

        self::renderHiddenField($key, $name, $value, 'date');
		self::renderDay($key, $day);
		echo '.';
		self::renderMonth($key, $month);
		echo '.';
		self::renderYear($key, $year);
    }

    public static function renderDateTime($name, $key, $value)
    {
        if (empty($value)) {
            $value = time();
        }
        $day = date('j', $value);
        $month = date('n', $value);
        $year = date('Y', $value);

        $hour = date('G', $value);
        $minute = intval(date('i', $value));

        self::renderHiddenField($key, $name, $value, 'datetime');

		self::renderDay($key, $day);
		echo '.';
		self::renderMonth($key, $month);
		echo '.';
		self::renderYear($key, $year);
		echo '&ensp;&ensp;';
		self::renderHour($key, $hour);
		echo ':';
		self::renderMinute($key, $minute);
		echo 'Uhr';
    }

    private static function renderDay($key, $value) {
        self::renderSelect(1, 31, $key, 'day', $value, 45);
    }

    private static function renderMonth($key, $value) {
        self::renderSelect(1, 12, $key, 'month', $value, 45);
    }

    private static function renderYear($key, $value) {
        self::renderSelect(2000, 2050, $key, 'year', $value, 60);
    }

    private static function renderHour($key, $value) {
        self::renderSelect(0, 23, $key, 'hour', $value, 45);
    }

    private static function renderMinute($key, $value) {
        self::renderSelect(0, 59, $key, 'minute', $value, 45);
    }

    private static function renderSelect($from, $to, $key, $subkey, $value, $px) {
        $options = [];
        for ($i = $from; $i <= $to; $i++) {
            $displayValue = $i;
            if ($i < 10) {
                $displayValue = '0' . $i;
            }
            $options[] = self::createOption($i, $value, $displayValue);
        }
        ?>
        <select onchange="handballDateChanged('<?= $key ?>')" style="width:<?= $px ?>px;" id="<?= $key . '_' . $subkey ?>" >
        	<?= implode('', $options) ?>
        </select>
		<?php
    }

    private static function createOption($value, $selectedValue, $displayValue) {
        $selected = selected($selectedValue, $value, false);
        return '<option '.$selected.' value="'.$value.'">'.$displayValue.'</option>';
    }

    private static function renderHiddenField($key, $name, $value, $type)
    {
        ?>
        <label for="<?= $key?>"><?= $name ?></label>
        <br />
        <input name="<?= $key?>" id="<?= $key ?>" type="hidden" value="<?= $value ?>" data-type="<?= $type ?>"></input>
        <?php
        if (!self::$registerOnce) {
            self::$registerOnce = true;
            ?>
            <script>
			function handballDateChanged(key) {
				var type = document.getElementById(key).dataset.type;
				var day = handballValueFromSelect(key + "_day");
				var month = handballValueFromSelect(key + "_month");
				var year = handballValueFromSelect(key + "_year");
				if (type == 'datetime') {
					var hours = handballValueFromSelect(key + "_hour");
					var minutes = handballValueFromSelect(key + "_minute");
					var dateString = day + "-" + month + "-" + year + "-" + hours + "-" + minutes;
					document.getElementById(key).value = dateString;
				} else {
					var dateString = day + "-" + month + "-" + year;
					document.getElementById(key).value = dateString;
				}
			}


			function handballValueFromSelect(id) {
				var e = document.getElementById(id);
				return e.options[e.selectedIndex].value;
			}
	        </script>
            <?php
        }
    }
}
