<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class AddCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'add {numbers* : The numbers to be added}';

    /**
     * @var string
     */
    protected $description = "Add all given Numbers";

    protected $storage = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $result = $this->processedCalculation();
        echo $result. "\n";
    }

    protected function processedCalculation() {
        $number = $this->getInput();

        if(count($number) > 0) {
            $description       = $this->generateCommand($number);
            $resultCalculation = $this->calculateAll($number);

            $finalResult = strval($description)." = ".strval($resultCalculation);
            $this->processedFile($description, $resultCalculation, $finalResult);

        } else {
            $this->info('Please fill your numbers!');
            exit;
        }

        return $finalResult;
    }

    protected function processedFile($description, $result, $output) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $this->storage = [
            'command' => $this->getCommandVerb(),
            'description' => $description,
            'result' => $result,
            'output' => $output,
            'time' => $now
        ];

        $file    = fopen('src/history.txt', 'a');
        $content = $this->storage['command'].';'.$this->storage['description'].';'.$this->storage['result'].';'.$this->storage['output'].';'.$this->storage['time'];

        fwrite($file, $content. "\n");
        fclose($file);
    }

    protected function getInput()
    {
        return $this->argument('numbers');
    }

    protected function getOperator(): string
    {
        return '+';
    }

    protected function generateCommand($arrayNumber)
    {
        return implode(' + ', $arrayNumber);
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $result = null;
        if(count($numbers) > 0) {
            $result = array_sum($numbers);
        }

        return $result;
    }

    protected function getCommandVerb(): string
    {
        return 'Add';
    }

}
