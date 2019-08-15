<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class PowCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'pow {base : The base number} {exp : The exponent number}';

    /**
     * @var string
     */
    protected $description = "Exponent the given number";

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
        $base = $this->getBase();
        $exp  = $this->getExp();

        if($base && $exp) {
            $description       = $this->generateCommand($base, $exp);
            $resultCalculation = $this->calculateAll($base, $exp);

            $finalResult = strval($description)." = ".strval($resultCalculation);
            $this->processedFile($description, $resultCalculation, $finalResult);

        } else {
            $this->info('Please fill your base number and exponent number!');
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

    protected function getBase()
    {
        return $this->argument('base');
    }

    protected function getExp()
    {
        return $this->argument('exp');
    }

    protected function getOperator(): string
    {
        return '^';
    }

    protected function generateCommand($base, $exp)
    {
        return $base. ' ^ '. $exp;
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll($base, $exp)
    {
        $result = pow($base, $exp);
        return $result;
    }

    protected function getCommandVerb(): string
    {
        return 'Pow';
    }

}
