<?php
/**
 * Template Functions
 */

namespace Russ\Events;

use IntlDateFormatter, DateTime;

/**
 * Returns a formatted date.
 *
 * @param string $date A date string.
 * @return string The formatted date.
 */
function get_date() {
	if ( ! class_exists( 'IntlDateFormatter' ) ) {
		return '';
	}

	$locale   = get_locale();
	$from     = strtotime( get_field( 'start_date' ) );
	$to       = strtotime( get_field( 'end_date' ) );
	$multiday = get_field( 'multi_day_event' );

	if ( $multiday ) {
		
		// Determine the type of mult-date format.
		$multi_year  = false;
		$multi_month = false;
		$from_year   = date( 'Y', $from );
		$to_year     = date( 'Y', $to );

		if ( $from_year != $to_year ) {
			$multi_year = true;
		} else {
			$from_month = date( 'm', $from );
			$to_month   = date( 'm', $to );
			if ( $from_month != $to_month ) {
				$multi_month = true;
			}
		}
	}

	if ( 'sv_SE' === $locale ) {
		$dash = ' &#8212; ';
	} else {
		$dash = ' - ';
	}

	// Create empty date formatters.
	$formatter_from = new IntlDateFormatter( $locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE );
	$formatter_to   = new IntlDateFormatter( $locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE );
	$formatter_to2  = new IntlDateFormatter( $locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE );

	if ( $multiday ) {

		switch ( $locale ) {
			case 'it_IT' :
			case 'en_AU' :
			case 'pt_BR' :
			case 'es_MX' :
			case 'nl_BE' :
			case 'fr_BE' :
			case 'fr_CA' :
			case 'es_ES' :
			case 'en_HK' :
			case 'fr_FR' :
			case 'en_IE' :
			case 'nl_NL' :
			case 'pl_PL' :
			case 'sv_SE' :
			case 'fr_CH' :
			case 'it_CH' :
			case 'en_GB' :
				// Format for Italy and countries using the same format.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'd MMMM y' );
					$date = $formatter_from->format( $from ) . $dash . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'd MMMM' );
					$date = $formatter_from->format( $from) . $dash . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'd' );
					$date = $formatter_from->format( $from) . $dash . $formatter_to->format( $to );
				}
				break;
			case 'en_NZ' :
			case 'en_SG' :
			case 'en_IN' :
				// Format for Canada and countries using the same format.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'dd MMMM, y' );
					$formatter_to->setPattern( 'dd MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'dd MMMM' );
					$formatter_to->setPattern( 'dd MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'dd' );
					$formatter_to->setPattern( 'dd MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				}
				break;
			case 'en_HK' :
				// Format for Belgium.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'dd MMMM, y' );
					$formatter_to->setPattern( 'dd MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'dd MMMM' );
					$formatter_to->setPattern( 'dd MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'dd' );
					$formatter_to->setPattern( 'dd MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				}
				break;
			case 'de_DE' :
				// Format for Germany.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'd. MMMM y' );
					$formatter_to->setPattern( 'd. MMMM y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'd. MMMM' );
					$formatter_to->setPattern( 'd. MMMM y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'd.' );
					$formatter_to->setPattern( 'd. MMMM y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				}
				break;
			case 'de_CH' :
				// Format for German Dutch.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'dd. MMMM, y' );
					$formatter_to->setPattern( 'dd. MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'dd. MMMM' );
					$formatter_to->setPattern( 'dd. MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'dd.' );
					$formatter_to->setPattern( 'dd. MMMM, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				}
				break;
			case 'ja_JP' :
				// Format for Japan.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'y年MMM月d' );
					$formatter_to->setPattern( 'y年MMM月d日' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'y年MM月' );
					$formatter_to->setPattern( 'MM月日' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'y年MM月dd' );
					$formatter_to->setPattern( 'd日' );
					$date = $formatter_from->format( $from ) . ' ～ ' . $formatter_to->format( $to );
				}
				break;
			default :
				// en_US, en_CA, and default if it is something else.
				if ( $multi_year ) {
					$formatter_from->setPattern( 'MMMM dd, y' );
					$formatter_to->setPattern( 'MMMM dd, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} elseif ( $multi_month ) {
					$formatter_from->setPattern( 'MMMM dd' );
					$formatter_to->setPattern( 'MMMM dd, y' );
					$date = $formatter_from->format( $from ) . ' - ' . $formatter_to->format( $to );
				} else {
					$formatter_from->setPattern( 'dd' );
					$formatter_to->setPattern( 'MMMM ' );
					$formatter_to2->setPattern( 'dd, y' );
					$date = $formatter_to->format( $to ) . $formatter_from->format( $from ) . ' - ' . $formatter_to2->format( $to );
				}
		}

	} else {
		$intl_date_formatter = new IntlDateFormatter( $locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE );
		$date                = $intl_date_formatter->format( $from );
	}

	return $date;
}

/**
 * Returns a formatted time.
 * 
 * @param string $date A time string.
 * @return string The formatted time.
 */
function get_time() {
	$from = get_field( 'from_time' );
	if ( ! $from ) {
		return '';
	}

	$to = get_field( 'to_time' );

	$time = date( get_option( 'time_format' ), strtotime( $from ) );

	if ( $to ) {
		$time .= ' - ' . date( get_option( 'time_format' ), strtotime( $to ) );
	}

	return $time;
}
