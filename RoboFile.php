<?php
/**
 * This is the RoboFile for Bootgenie
 *
 * @see http://robo.li/
 */

class RoboFile extends \Robo\Tasks
{
  private $vendorDir;
  private $assetPackages;

  /**
   * Contruct for the class, checks and creates the dist folders
   */
  public function __construct() {
    // check the build folder
    $buildDirs = array(
      'assets/styles',
      'assets/scripts',
      'assets/fonts'
    );
    $this->createPaths($buildDirs);

    // get the vendorDir
    $io = new Composer\IO\NullIO();
    $factory = new Composer\Factory();
    $composer = $factory->createComposer($io);
    $this->vendorDir = rtrim($composer->getConfig()->get('vendor-dir'), '/');

    // go through installed packages (taken from Composer\Command\ShowCommand.php)
    $installedRepo = $composer->getRepositoryManager()->getLocalRepository();
    $this->assetPackages = [];
    foreach ($installedRepo->getPackages() as $package) {
      if ($package->getType() == 'bower-asset-library' ) {
        // store the extra information for assets
        $this->assetPackages[$package->getPrettyName()] = $package;
      }
    }
  }

  private function createPaths($paths){
    // iterate through paths array and create folder
    foreach ($paths as $path) {
      // use Symfony 2 mkdir for recursive directory creation
      if (! is_dir($path)) {
        $this->_mkdir($path);
      }
    }
  }

  private function getAssetPath($packageName) {
    foreach ($this->assetPackages as $k => $package) {
      if ( strpos($k, $packageName) !== FALSE) {
        return $this->vendorDir .'/'. $k . '/';
      }
    }
  }

  private function getAssetMain($packageName) {
    foreach ($this->assetPackages as $k => $package) {
      if ( strpos($k, $packageName) !== FALSE) {
        $extra = $package->getExtra();
        $main = '';
        if (isset($extra['bower-asset-main'])) $main = $extra['bower-asset-main'];
        // check if single value is given, then return a string instead of an array
        if (is_array($main) && count($main) == 1){
          $main = $this->vendorDir.'/bower-asset/'.$packageName.'/'.$main[0];
        }
        return $main;
      }
    }
  }

  /**
   * Main build step
   */
  public function build() {
    $this->styles();
    $this->scripts();
    $this->fonts();
    $this->images();
  }

  /** 
   * Compiles and optimizes SCSS stylesheets
   */
  public function styles() {
    $this->taskScss(
      [
        'sources/styles/main.scss' => 'assets/styles/bootgenie.css'
      ]
    )
    ->addImportPath('sources/styles')
    ->addImportPath($this->getAssetPath('bootstrap').'/assets/stylesheets')
    // add custom function to include plain CSS file
    ->addImportPath(function($path) {
          if (!file_exists($this->getAssetPath('yamm3').$path)) return null;
              return $this->getAssetPath('yamm3').$path;
    })
    ->setFormatter('Leafo\ScssPhp\Formatter\Compressed')
    ->run();
  }

  /**
   * Minimize scripts and put them into the asset folder
   */
  public function scripts() {
    $this->taskMinify($this->getAssetPath('bootstrap').'assets/javascripts/bootstrap.js')
      ->to('assets/scripts/bootstrap.js')
      ->run();
  }

  /**
   * Grab all the fonts and put them in a flattened directory structure
   */
  public function fonts() {
    $fonts = $this->getAssetPath('bootstrap').'assets/fonts/bootstrap/*';
    /*
    $this->taskFlattenDir($fonts)
      ->to('assets/fonts')
      ->run();
     */
  }

  /**
   * Run lossless compression on all the images.
   */
  public function images() {
    $this->say('TODO: implement imagemin');
  }

  /** 
   * Watch the files and recompile them
   */
  public function watch() {
    $this->taskWatch()
      ->monitor('assets/styles/main.scss', function() {
        $this->styles();
      })
      ->monitor('assets/styles/bootgenie.scss', function() {
        $this->styles();
      })
      ->run();
  }
}
