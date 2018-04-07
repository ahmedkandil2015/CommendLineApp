<?php

namespace Acme;


use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZipArchive;


class NewCommend extends Command
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    public function configure(){
        $this->setName("new")
            ->setDescription('Create a new Kandilcast application')
            ->addArgument('name',InputArgument::REQUIRED);

    }
    public function execute(InputInterface $input,OutputInterface $output){

            $directory = getcwd().'/'.$input->getArgument('name');
        $output->writeln('<info>Crafting Application... </info>');

        $this->assertApplicationDoesNotExist($directory,$output);
            $this->download($zipfile=$this->makeFileName())
                 ->extract($zipfile,$directory)
                 ->cleanUp($zipfile);



                $output->writeln('<comment>Application ready !</comment>');
        //alert the user that they are ready to go



    }

    private function assertApplicationDoesNotExist($directory,OutputInterface $output){

        if (is_dir($directory)){

            $output->writeln('<error>This Application Already exists !</error>');
            exit(1);
        }
    }
    private function makeFileName(){

        return getcwd().'/laravel_'.md5(time().uniqid()).'.zip';
    }
    private function download($zipfile)
    {
       $response= $this->client->get('https://github.com/ahmedkandil2015/Simple-MVC-Framwork/archive/master.zip')->getbody();
       file_put_contents($zipfile,$response);
       return $this;
    }
    private function extract($zipfile,$directory){
        $archive = new ZipArchive();
        $archive->open($zipfile);
        $archive->extractTo($directory);
        $archive->close();

        return $this;
    }
    private function cleanUp($zipFile){
        @chmod ($zipFile,0777);
        @unlink($zipFile);
        return $this;

    }

}