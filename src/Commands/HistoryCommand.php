<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class HistoryCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'history:list';

    /**
     * @var string
     */
    protected $description = "Show calculator history";
    protected $urlFile = "src/history.txt";


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->validateFile();
        $this->createHeader();
        $this->processedFile();

        // $result = $this->processedCalculation();
        // echo $result. "\n";
    }

    protected function createHeader() {
        $this->line('+----+----------+-----------------+--------+---------------------+---------------------+');
        $this->line('| '.'No'.' | '.'Command '.' | '.'Description    '.' | '.'Result'.' | '.'Output             '.' | '.'Time               '.' |');
        $this->line('+----+----------+-----------------+--------+---------------------+---------------------+');
    }

    protected function validateFile() {

        if(!file_exists($this->urlFile)) {
            $this->info('History is empty.');
            exit;
        } else {
            $read = file($this->urlFile);
            if(!count($read)) {
                $this->info('History is empty.');
                exit;
            }
        }
    }

    protected function processedFile() {
        $contentArr = [];

        if(file_exists($this->urlFile)) {
            $read = file($this->urlFile);
            $idx = 1;
            foreach($read AS $r) {

                $arrExplode = explode(';', $r);
                array_push($contentArr, [
                    "no" => $idx,
                    "command" => $arrExplode[0],
                    "description" => $arrExplode[1],
                    "result" => $arrExplode[2],
                    "output" => $arrExplode[3],
                    "time" => $arrExplode[4],
                ]);
                $idx ++;
            }
        } else {

        }
        //echo print_r($contentArr, true);

        // fill the content
        $this->filledContent($contentArr);

    }

    protected function filledContent($contentArr) {

        foreach ($contentArr as $content) {
            echo '| '.$content['no'].'  | '.$content['command'].'      | '.$content['description'].'           | '.$content['result'].'      | '.$content['output'].'      | '.$content['time'];
        }
    }



}
