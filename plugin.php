<?php

class pageTopButton extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'buttonColor' => '#bbbbbb',
			'buttonShape' => 'squared',
			'buttonType' => 'normal',
			'iconType' => 'chevron',
			'fadeOutEffect' => false
		);
	}

	public function form()
	{
		global $L;

		$html .= '<!-- Load coloris stylesheet -->';
		$html .= '<link rel="stylesheet" href="'. DOMAIN_PLUGINS .'page-top-button/coloris/coloris.min.css"/>';

		$html .= '<h4 class="mt-3">'. $L->get('button-apperance') .'</h3>';

		$html .= '<div>';
		$html .= '<label>'. $L->get('button-color') .'</label>';
		$html .= '<input name="buttonColor" class="form-control" type="text" dir="auto" value="' . $this->getValue('buttonColor') . '" data-coloris>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'. $L->get('button-shape') .'</label>';
		$html .= '<select name="buttonShape">';
		$html .= '<option value="squared" ' . ($this->getValue('buttonShape') === 'squared' ? 'selected' : '') . '>'. $L->get('squared') .'</option>';
		$html .= '<option value="corner-rounded" ' . ($this->getValue('buttonShape') === 'corner-rounded' ? 'selected' : '') . '>'. $L->get('corner-rounded') .'</option>';
		$html .= '<option value="rounded" ' . ($this->getValue('buttonShape') === 'rounded' ? 'selected' : '') . '>'. $L->get('rounded') .'</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'. $L->get('button-type') .'</label>';
		$html .= '<select name="buttonType">';
		$html .= '<option value="normal" ' . ($this->getValue('buttonType') === 'normal' ? 'selected' : '') . '>'. $L->get('normal') .'</option>';
		$html .= '<option value="outlined" ' . ($this->getValue('buttonType') === 'outlined' ? 'selected' : '') . '>'. $L->get('outlined') .'</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'. $L->get('icon-shape') .'</label>';
		$html .= '<select name="iconType">';
		$html .= '<option value="chevron" ' . ($this->getValue('iconType') === 'chevron' ? 'selected' : '') . '>'. $L->get('chevron') .'</option>';
		$html .= '<option value="arrow" ' . ($this->getValue('iconType') === 'arrow' ? 'selected' : '') . '>'. $L->get('arrow') .'</option>';
		$html .= '<option value="triangle" ' . ($this->getValue('iconType') === 'triangle' ? 'selected' : '') . '>'. $L->get('triangle') .'</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'. $L->get('fade-out-effect-on-scroll') .'</label>';
		$html .= '<select name="fadeOutEffect">';
		$html .= '<option value="true" ' . ($this->getValue('fadeOutEffect') === true ? 'selected' : '') . '>'. $L->get('enabled') .'</option>';
		$html .= '<option value="false" ' . ($this->getValue('fadeOutEffect') === false ? 'selected' : '') . '>'. $L->get('disabled') .'</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<!-- Load coloris script -->';
		$html .= '<script src="'. DOMAIN_PLUGINS .'page-top-button/coloris/coloris.min.js"></script>';

		return $html;
	}

	public function siteHead()
	{
		global $page;

		// Load button CSS
		return $this->buttonStyle();
	}

	private function buttonStyle()
	{
		//Icon color
		$buttonColor = $this->getValue('buttonColor');

		//Button border radius
		if ($this->getValue('buttonShape') == 'squared') {
			$buttonBorderRadius = '0';
		} elseif ($this->getValue('buttonShape') == 'corner-rounded') {
			$buttonBorderRadius = '5px';
		}	elseif ($this->getValue('buttonShape') == 'rounded') {
			$buttonBorderRadius = '50%';
		}

		// Button color settings
		if ($this->getValue('buttonType') == 'normal') {
			$buttonBackgroundColor = $buttonColor;
			$buttonBorderColor = 'transparent';
			$iconStroke = '#fff';
		} elseif ($this->getValue('buttonType') == 'outlined') {
			$buttonBackgroundColor = 'transparent';
			$buttonBorderColor = $buttonColor;
			$iconStroke = $buttonColor;
		}

		if ($this->getValue('iconType') == 'triangle' && $this->getValue('buttonType') == 'normal') {
			$iconFill = '#fff';
		} elseif ($this->getValue('iconType') == 'triangle' && $this->getValue('buttonType') == 'outlined') {
			$iconFill = $buttonColor;
		} else {
			$iconFill = 'none';
		}

		// Icon sizes
		if ($this->getValue('iconType') == 'arrow') {
			$iconSize = '40px';
			$iconMargin = '2px';
		} elseif ($this->getValue('iconType') == 'triangle') {
			$iconSize = '15px';
			$iconMargin = '4px';
		} elseif ($this->getValue('iconType') == 'chevron') {
			$iconSize = '40px';
			$iconMargin = '6px';
		}

		if ($this->getValue('fadeOutEffect') == true) {
			$fadeOutTransitionTime = '0.3s';
		} else {
			$fadeOutTransitionTime = '0';
		}

		// Code to output
		$codeCSS = <<<EOF
		<style>
		/* page-top-button */
		.page-top-button {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background: $buttonBackgroundColor;
		display: inline-block;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		text-align: center;
		vertical-align: middle;
		text-decoration: none;
		border: 2px solid $buttonBorderColor;
		border-radius: $buttonBorderRadius;
		line-height: 50px;

		width: 50px;
		height: 50px;
		padding: 0;
		margin: 0;

		opacity: 0;
		transition: $fadeOutTransitionTime;
		z-index: 100;
		}

		.page-top-button svg {
		height: $iconSize;
		width: $iconSize;
		stroke: $iconStroke;
		fill: $iconFill;
		vertical-align: middle;
		padding: 0;
		margin: 0;
		margin-bottom: $iconMargin;
		}
		</style>
		EOF;
		return $codeCSS.PHP_EOL;
	}

	public function siteBodyBegin()
	{
		global $page;

		return $this->buttonContent();
	}

	private function buttonContent()
	{
		global $page;

		// Icon SVG
		if ($this->getValue('iconType') == 'arrow') {
			$iconSrc = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>';
		} elseif ($this->getValue('iconType') == 'triangle') {
			$iconSrc = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle"><path d="M13.73 4a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/></svg>';
		} elseif ($this->getValue('iconType') == 'chevron') {
			$iconSrc = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg>';
		}

		// Code to output
		$codeHTML = <<<EOF
		<div class="page-top-button">
			$iconSrc
		</div>
		EOF;

		return $codeHTML;
	}

	public function siteBodyEnd()
	{
		global $page;

		echo '<!-- page-top-button scripts -->'.PHP_EOL;
		echo '<script src="'. DOMAIN_PLUGINS .'page-top-button/js/smoothscroll.js"></script>'.PHP_EOL;
		echo '<script src="'. DOMAIN_PLUGINS .'page-top-button/js/page-top-button.js"></script>'.PHP_EOL;

	}
}
