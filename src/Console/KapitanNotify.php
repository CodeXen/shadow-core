<?php 

namespace Shadow\Console;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class KapitanNotify
{
	public static function render($type = 'success', $message, $output, $command) {
		$successStyle = new OutputFormatterStyle('white', 'green');
		$output->getFormatter()->setStyle('success', $successStyle);

		$infoStyle = new OutputFormatterStyle('white', 'blue');
		$output->getFormatter()->setStyle('info', $infoStyle);

		$dangerStyle = new OutputFormatterStyle('white', 'red');
		$output->getFormatter()->setStyle('danger', $dangerStyle);

		$formatter = $command->getHelper('formatter');

		$infoMessage = $message;
		$formattedInfoBlock = $formatter->formatBlock($infoMessage, $type, TRUE);
		
		$output->writeln($formattedInfoBlock);
		$output->writeln('');
	}
}