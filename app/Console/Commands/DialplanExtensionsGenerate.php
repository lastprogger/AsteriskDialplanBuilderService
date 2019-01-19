<?php

namespace App\Console\Commands;

use App\Domain\Models\ExtensionsStorage;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DialplanExtensionsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DialplanExtensionsGenerate {amount} {--testing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dialplan extensions 
                                {amount : amount of extensions which should be created}
                                ';

    protected $filePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->filePath = app_path() . '/../storage/extensions_custom.conf';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('--------------');
        $this->info('Start');

        $amount = $this->argument('amount');
        $bar    = $this->output->createProgressBar($amount);

        $bar->start();

        $errors  = 0;
        $created = 0;

        $strStart = PHP_EOL . PHP_EOL.  ';---------- Created ' . now()->format('d-m-Y') . ', amount:' . $amount . ' ------------';

        file_put_contents($this->filePath, $strStart, FILE_APPEND);

        for ($i = 0; $i < $amount; $i++) {

            try {
                $exten = uniqid();
                $data  = $this->makeExtensionData($exten);

                if (!$this->option('testing')) {dd('123');
                    $this->writeToFile($data);
                }
                $this->storeExtension($exten);
                $bar->advance();
                ++$created;
            } catch (Exception $e) {
                Log::error($e);
                ++$errors;
            }
        }
        $bar->finish();
        $this->info(' ');
        $this->info('Successful created: ' . $created);
        $this->info('Errors: ' . $errors);
        $this->info('Completed!');
        $this->info('--------------');
    }

    /**
     * @return array
     */
    private function makeExtensionData(string $exten): array
    {
        return [
            'exten =>' . $exten . ',1(start),NoOp()',
            'switch=>Realtime/@',
        ];
    }

    private function storeExtension(string $exten): void
    {
        $extenStorage        = new ExtensionsStorage();
        $extenStorage->exten = $exten;
        $extenStorage->save();
    }

    private function writeToFile(array $data): void
    {
        $strData = PHP_EOL . PHP_EOL . implode(PHP_EOL, $data);

        file_put_contents($this->filePath, $strData, FILE_APPEND);
    }
}
