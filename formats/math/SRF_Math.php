<?php

/**
 * Various mathematical functions - sum, product, average, min, max, median, variance, samplevariance, samplestandarddeviation, standarddeviation, range, quartillower, quartilupper, quartillower.exc, quartilupper.exc, interquartilerange, interquartilerange.exc, mode and interquartilemean
 *
 * @license GPL-3.0-or-later
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Yaron Koren
 * @author Nathan Yergler
 * @author Florian Breitenlacher
 */

class MathFormats {
	public static function max_function( array $numbers ) {
		// result
		return max( $numbers );
	}

	public static function min_function( array $numbers ) {
		// result
		return min( $numbers );
	}

	public static function sum_function( array $numbers ) {
		// result
		return array_sum( $numbers );
	}

	public static function product_function( array $numbers ) {
		// result
		return array_product( $numbers );
	}

	public static function average_function( array $numbers ) {
		// result
		return array_sum( $numbers ) / count( $numbers );
	}

	public static function median_function( array $numbers ) {
		sort( $numbers, SORT_NUMERIC );
		// get position
		$position = ( count( $numbers ) + 1 ) / 2 - 1;
		// result
		return ( $numbers[ceil( $position )] + $numbers[floor( $position )] ) / 2;
	}

	public static function variance_function( array $numbers ) {
		// average
		$average = self::average_function( $numbers );
		// space
		$space = null;
		for ( $i = 0; $i < count( $numbers ); $i++ ) {
			$space += pow( $numbers[$i], 2 );
		}
		// result
		return ( $space / count( $numbers ) - pow( $average, 2 ) );
	}

	public static function samplevariance_function( array $numbers ) {
		// average
		$average = self::average_function( $numbers );
		// space
		$space = null;
		for ( $i = 0; $i < count( $numbers ); $i++ ) {
			$space += pow( ( $numbers[$i] - $average ), 2 );
		}
		// result
		return ( $space / ( count( $numbers ) - 1 ) );
	}

	public static function standarddeviation_function( array $numbers ) {
		// average
		$average = self::average_function( $numbers );
		// space
		$space = null;
		for ( $i = 0; $i < count( $numbers ); $i++ ) {
			$space += pow( ( $numbers[$i] - $average ), 2 );
		}
		// result
		return sqrt( $space / ( count( $numbers ) - 1 ) );
	}

	public static function samplestandarddeviation_function( array $numbers ) {
		// average
		$average = self::average_function( $numbers );
		// space
		$space = null;
		for ( $i = 0; $i < count( $numbers ); $i++ ) {
			$space += pow( $numbers[$i], 2 );
		}
		// result
		return sqrt( $space / count( $numbers ) - pow( $average, 2 ) );
	}

	public static function range_function( array $numbers ) {
		// result
		return ( max( $numbers ) - min( $numbers ) );
	}

	public static function quartillower_inc_function( array $numbers ) {
		sort( $numbers, SORT_NUMERIC );
		// get position
		$Q1_position = ( ( count( $numbers ) - 1 ) * 0.25 );
		// check if position is between two numbers
		if ( is_float( $Q1_position ) == true ) {
			$Q1_position_y = floor( $Q1_position );
			$Q1_position_x = ceil( $Q1_position );
			// result
			return ( $numbers[$Q1_position_y] + ( $numbers[$Q1_position_x] - $numbers[$Q1_position_y] ) * 0.25 );
		} else {
			// result
			return $numbers[$Q1_position];
		}
	}

	public static function quartilupper_inc_function( array $numbers ) {
		sort( $numbers, SORT_NUMERIC );
		// get position
		$Q3_position = ( ( count( $numbers ) - 1 ) * 0.75 );
		// check if position is between two numbers
		if ( is_float( $Q3_position ) == true ) {
			$Q3_position_y = floor( $Q3_position );
			$Q3_position_x = ceil( $Q3_position );
			// result
			return ( $numbers[$Q3_position_y] + ( $numbers[$Q3_position_x] - $numbers[$Q3_position_y] ) * 0.75 );
		} else {
			// result
			return $numbers[$Q3_position];
		}
	}

	public static function quartillower_exc_function( array $numbers ) {
		sort( $numbers, SORT_NUMERIC );
		// get position
		$Q1_position = ( ( count( $numbers ) + 1 ) * 0.25 );
		// check if position is between two numbers
		if ( is_float( $Q1_position ) == true ) {
			$Q1_position_y = floor( $Q1_position ) - 1;
			$Q1_position_x = ceil( $Q1_position ) - 1;
			// result
			return ( $numbers[$Q1_position_y] + ( $numbers[$Q1_position_x] - $numbers[$Q1_position_y] ) * 0.75 );
		} else {
			// result
			return $numbers[$Q1_position];
		}
	}

	public static function quartilupper_exc_function( array $numbers ) {
		sort( $numbers, SORT_NUMERIC );
		// get position
		$Q3_position = ( ( count( $numbers ) + 1 ) * 0.75 );
		// check if position is between two numbers
		if ( is_float( $Q3_position ) == true ) {
			$Q3_position_y = floor( $Q3_position ) - 1;
			$Q3_position_x = ceil( $Q3_position ) - 1;
			// result
			return ( $numbers[$Q3_position_y] + ( $numbers[$Q3_position_x] - $numbers[$Q3_position_y] ) * 0.25 );
		} else {
			// result
			return $numbers[$Q3_position];
		}
	}

	public static function interquartilerange_inc_function( array $numbers ) {
		// result
		return self::quartilupper_inc_function( $numbers ) - self::quartillower_inc_function( $numbers );
	}

	public static function interquartilerange_exc_function( array $numbers ) {
		// result
		return self::quartilupper_exc_function( $numbers ) - self::quartillower_exc_function( $numbers );
	}

	public static function mode_function( array $numbers ) {
		// array temp
		$array_temp = [];
		// convert array
		for ( $i = 0; $i < count( $numbers ); $i++ ) {
			$converted_value = strval( $numbers[$i] );
			$array_temp += [ $i => $converted_value ];
		}
		$array_counted_values = array_count_values( $array_temp );
		// max
		$max = max( $array_counted_values );
		// count
		$count = null;
		// filter
		for ( $i = 0; $i < count( $array_counted_values ); $i++ ) {
			if ( $array_counted_values[array_keys( $array_counted_values )[$i]] == $max ) {
				$count += 1;
			}
		}
		// check if there are more than one max
		if ( $count == 1 ) {
			// result
			return $max;
		}
	}

	public static function interquartilemean_function( array $numbers ) {
		// sort numbers
		sort( $numbers, SORT_NUMERIC );
		// check if size of numbers is divisible by 4
		if ( count( $numbers ) % 4 == 0 ) {
			// split array into 4 groups (2D array)
			$array_split = ( array_chunk( $numbers, count( $numbers ) / 4 ) );
			// creating store_string
			$store_string = null;
			for ( $i = 0; $i < count( $array_split[1] ); $i++ ) {
				$store_string += $array_split[1][$i];
			}
			for ( $i = 0; $i < count( $array_split[2] ); $i++ ) {
				$store_string += $array_split[2][$i];
			}
			// result
			return $store_string / ( count( $array_split[1] ) + count( $array_split[2] ) );
		} else {
			// get position of split
			$position = count( $numbers ) / 4;
			// remove values out of split
			for ( $i = 0; $i < floor( $position ); $i++ ) {
				unset( $numbers[$i] );
				array_pop( $numbers );
			}
			// reset array keys
			$store_array = array_merge( $numbers );
			// add values
			$store_values = null;
			for ( $i = 1; $i < count( $store_array ) - 1; $i++ ) {
				$store_values += $store_array[$i];
			}
			// result
			return ( $store_values + ( ( ceil( $position ) - $position ) * ( $store_array[0] + $store_array[count( $store_array ) - 1] ) ) ) / ( $position * 2 );
		}
	}
}

class SRFMath extends SMWResultPrinter {

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::getName()
	 */
	public function getName() {
		// Give grep a chance to find the usages:
		// srf_printername_max, srf_printername_min, srf_printername_sum,
		// srf_printername_product, srf_printername_average, srf_printername_median
		return wfMessage( 'srf_printername_' . $this->mFormat )->text();
	}

	/**
	 * @see SMWResultPrinter::buildResult
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $results
	 *
	 * @return string
	 */
	protected function buildResult( SMWQueryResult $results ) {
		$number = $this->getResultText( $results, SMW_OUTPUT_HTML );

		if ( count( $results->getPrintRequests() ) > 1 ) {
			$outputformat = $results->getPrintRequests()[1]->getOutputFormat();
		} else {
			// no mainlabel
			$outputformat = $results->getPrintRequests()[0]->getOutputFormat();
		}

		// if raw-format ("-") than skip formatNum()
		if ( $outputformat != "-" ) {
			$dataValue = \SMW\DataValueFactory::getInstance()->newDataValueByType( '_num' );
			$number = $dataValue->getLocalizedFormattedNumber( $number );
		}

		return (string)$number;
	}

	/**
	 * @see SMWResultPrinter::getResultText()
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		$data = false;
		$numbers = $this->getNumbers( $res, $data );

		if ( count( $numbers ) == 0 ) {
			return $this->params['default'];
		}

		switch ( $this->mFormat ) {
			case 'max':
				$number = MathFormats::max_function( $numbers );
				break;
			case 'min':
				$number = MathFormats::min_function( $numbers );
				break;
			case 'sum':
				$number = MathFormats::sum_function( $numbers );
				break;
			case 'product':
				$number = MathFormats::product_function( $numbers );
				break;
			case 'average':
				$number = MathFormats::average_function( $numbers );
				break;
			case 'median':
				$number = MathFormats::median_function( $numbers );
				break;
			case 'variance':
				$number = MathFormats::variance_function( $numbers );
				break;
			case 'samplevariance':
				$number = MathFormats::samplevariance_function( $numbers );
				break;
			case 'samplestandarddeviation':
				$number = MathFormats::samplestandarddeviation_function( $numbers );
				break;
			case 'standarddeviation':
				$number = MathFormats::standarddeviation_function( $numbers );
				break;
			case 'range':
				$number = MathFormats::range_function( $numbers );
				break;
			case 'quartillower':
				$number = MathFormats::quartillower_inc_function( $numbers );
				break;
			case 'quartilupper';
				$number = MathFormats::quartilupper_inc_function( $numbers );
				break;
			case 'quartillower.exc';
				$number = MathFormats::quartillower_exc_function( $numbers );
				break;
			case 'quartilupper.exc';
				$number = MathFormats::quartilupper_exc_function( $numbers );
				break;
			case 'interquartilerange':
				$number = MathFormats::interquartilerange_inc_function( $numbers );
				break;
			case 'interquartilerange.exc';
				$number = MathFormats::interquartilerange_exc_function( $numbers );
				break;
			case 'mode';
				$number = MathFormats::mode_function( $numbers );
				break;
			case 'interquartilemean';
				$number = MathFormats::interquartilemean_function( $numbers );
				break;
		}

		if ( is_numeric( $number ) && $number !== '' && $data !== false && method_exists( $data, 'getFormattedValue' ) ){
			return $data->getFormattedValue( $number );
		}
		return $number;
	}

	/**
	 * @param SMWQueryResult $res
	 *
	 * @return float[]
	 */
	private function getNumbers( SMWQueryResult $res, &$data ) {
		$numbers = [];
		$isfirst = true;

		while ( $row = $res->getNext() ) {
			if( $isfirst ){
				foreach ( $row as &$field ) {
					while ( $dv = $field->getNextDataValue() ) {
						if ( $dv->getDataItem()->getDIType() == SMWDataItem::TYPE_NUMBER || $dv->getDataItem()->getDIType() == \DurationExtensionSMWHooks::TYPE_PRICE ){
							$data = $dv;
							break 2;
						}
					}
				}
				$isfirst = false;
			}
			foreach ( $row as $resultArray ) {
				foreach ( $resultArray->getContent() as $dataItem ) {
					self::addNumbersForDataItem( $dataItem, $numbers );
				}
			}
		}

		return $numbers;
	}

	/**
	 * @param SMWDataItem $dataItem
	 * @param float[] &$numbers
	 */
	private function addNumbersForDataItem( SMWDataItem $dataItem, array &$numbers ) {
		switch ( $dataItem->getDIType() ) {
			case SMWDataItem::TYPE_NUMBER: case \DurationExtensionSMWHooks::TYPE_PRICE:
				$numbers[] = $dataItem->getNumber();
				break;
			case SMWDataItem::TYPE_CONTAINER:
				foreach ( $dataItem->getDataItems() as $di ) {
					self::addNumbersForDataItem( $di, $numbers );
				}
				break;
			default:
		}
	}

}
