// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';
import { formatDate } from '../utils';

/**
 * This is the preview-component for the Visual Builder.
 */
class Calendar extends Component {

	static slug = 'evrdm_calendar';

	render() {
		const isSmall       = 'on' === this.props.is_small;
		const showTime      = 'on' === this.props.show_time;
		const position      = this.props.position;
		const theClasses    = ['evrdm_calendar_item'];
		const dateFormat    = this.props.date_format;
		const timeFormat    = this.props.time_format;
		const iconTopStyles = {};
		const iconStyles    = {};

		if (this.props.icon_top_bg_color) {
			iconTopStyles.backgroundColor = this.props.icon_top_bg_color;
		}
		if (this.props.icon_bottom_bg_color) {
			iconStyles.backgroundColor = this.props.icon_bottom_bg_color;
		}

		let theDate = new Date(this.props.the_date);

		if (isNaN(theDate.getTime())) {
			theDate = new Date();
		}

		if ( isSmall ) {
			theClasses.push('size-small');
		} else {
			theClasses.push('size-big');
		}
		if ( showTime ) {
			theClasses.push('date-time');
		} else {
			theClasses.push('date-only');
		}

		theClasses.push('pos-' + position);

		return (
			<div className={theClasses.join(' ')}>
				<div className="icon" style={iconStyles}>
					<span className="month" style={iconTopStyles}>
						{formatDate('M', theDate)}
					</span>
					<span className="day">{formatDate('j', theDate)}</span>
				</div>
				<div className="dayname">{formatDate('l', theDate)}</div>
				<div className="date">{formatDate(dateFormat, theDate)}</div>
				{showTime
					? <div className="time">{formatDate(timeFormat, theDate)}</div>
					: ''
				}
				<div className="content">{this.props.content()}</div>
			</div>
		);
	}
}

export default Calendar;
