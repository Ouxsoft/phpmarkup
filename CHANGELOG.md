# Changelog for PHPMarkup

All releases must adhere to [SemVer 2](https://semver.org/) naming convention and should adhere to [KeepAChangeLog](https://keepachangelog.com/en/1.0.0/) guidelines.

>MAJOR version - when you make incompatible API changes,
>
>MINOR version - when you add functionality in a backwards compatible manner, and
>
>PATCH version - when you make backwards compatible bug fixes.

## PHPMarkup [Unreleased]
Released: TBA. Notable changes:

## PHPMarkup 4.3.2
Released: 2022-01-02. Notable changes:
* Changed: Fix null arg check.

## PHPMarkup 4.3.1
Released: 2022-01-02. Notable changes:
* Changed: Improved ArrayArgument keys.

## PHPMarkup 4.3.0
Released: 2022-01-01. Notable changes:
* Changed: Add PHP 8.1 support.

## PHPMarkup 4.2.6
Released: 2021-10-08. Notable changes:
* Changed: Marker attribute removal to end routine.

## PHPMarkup 4.2.5
Released: 2021-10-08. Notable changes:
* Fixed: QA tests.

## PHPMarkup 4.2.4
Released: 2021-10-08. Notable changes:
* Added: InnerXML sanitization.
* Added: Coverage CI tests.

## PHPMarkup 4.2.3
Released: 2021-10-06. Notable changes:
* Added: CI via Github Action.
* Added: Live argument access.

## PHPMarkup 4.2.2
Released: 2021-07-12. Notable changes:
* Fixed: Add Properties bug.

## PHPMarkup 4.2.1
Released: 2021-07-11. Notable changes:
* Added: Dynamically set Properties.

## PHPMarkup 4.2.0
Released: 2021-07-09. Notable changes:
* Added: Support for Args to contain XML.

## PHPMarkup 4.0.2
Released: 2021-04-24. Notable changes:
* Updated: Vendor packages.

## PHPMarkup 4.0.1
Released: 2021-04-06. Notable changes:
* Added: PHP 8 Support.

## PHPMarkup 4.0.0
Released: 2021-03-28. Notable changes:
* Added: Code of conduct.
* Added: PSR 12 Coding Standard.
* Changed: Repo name from "LivingMarkup" to PHPMarkup.

## PHPMarkup 3.0.2
Released: 2021-02-11. Notable changes:
* Added: Sphinx Doxygen PHP Generated documentation. [e232405](https://github.com/ouxsoft/PHPMarkup/commit/e232405d8f83f47a826f25fa0e4e2b5f55cb7cf6).
* Added: Ouxsoft namespace prefix [e232405](https://github.com/ouxsoft/PHPMarkup/commit/e232405d8f83f47a826f25fa0e4e2b5f55cb7cf6).

## PHPMarkup 3.0.1
Released: 2021-02-05. Notable changes:
* Fixed: Bug with recursive DOM element processing [dc574dc](https://github.com/ouxsoft/PHPMarkup/commit/dc574dcd708ad7627ffbbd16e8667e4e480dfc03).

## PHPMarkup 3.0.0
Released: 2021-02-03. Notable changes:
* Added: ProcessorFactory [925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).
* Added: Config version 3 support with Element and Routines [925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).
* Added: Routines to accept orchestrated array method calls and limitless settings [925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).
* Changed: Elements to accept an array of limitless settings [925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).
* Removed: Method call concept which was replaced with Routines [925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).
* Added: Setups and tear downs for PHPUnit tests.[925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).
* Added: Sphinx Documentation and RST [925e122](https://github.com/ouxsoft/PHPMarkup/commit/925e122ba8850c2d043de3eb9334c13f9d0632c6).

## PHPMarkup 2.0.0
Released: 2021-09-01. Notable changes:
* Fixed: TravisCI build. [de63d57](https://github.com/ouxsoft/PHPMarkup/commit/de63d574c6aa6470d19641a71adabd2e318ec9a0).
* Added: Integration with dedicated docker development [PHPMarkup-Dev](https://github.com/ouxsoft/phpmarkup-dev). [#e1912d8](https://github.com/ouxsoft/PHPMarkup/commit/e1912d87ad13e10732410527a63dbc8b33c1f7af).
* Added: Json config support. [#188c92c](https://github.com/ouxsoft/PHPMarkup/commit/188c92c44c255e1b3f9560bf1052503c48e07b69).
* Removed: Yaml config support (as requirement often caused build test and environments to fail). [#188c92c](https://github.com/ouxsoft/PHPMarkup/commit/188c92c44c255e1b3f9560bf1052503c48e07b69).

## PHPMarkup 1.6.0
Released: 2020-06-21. Notable changes:
* Added: Increased test coverage 100% [#f4299f9](https://github.com/ouxsoft/PHPMarkup/commit/f4299f94767713db802b98ea4475f632af4756d9).
* Moved: Renamed modules to elements [#ab93040](https://github.com/ouxsoft/PHPMarkup/commit/ab930407cad85415365cf8eb6a6c731eef4acddd).
* Added: Travis-CI [#ff66691](https://github.com/ouxsoft/PHPMarkup/commit/ff666915f50db6b5a1064ecf2a75d7143f65c704).

## PHPMarkup 1.5.3
Released: 2020-06-06. Notable changes:
*  Moved: Features hindering reuse as a LHTML processor as a library to [Hoopless](https://github.com/ouxsoft/hoopless).
*  Added: Processor API [#1660e1e](https://github.com/ouxsoft/PHPMarkup/commit/1660e1ee3500fcd2664d15ba2098ffa3e83e3206).
*  Removed: Web server (/docker, /bin, /public, /var, etc.). [#b672884](https://github.com/ouxsoft/PHPMarkup/commit/b67288498b72c94e574ae47e0f095e5ead29ded9).
*  Removed: Dynamic image generation. [#b672884](https://github.com/ouxsoft/PHPMarkup/commit/b67288498b72c94e574ae47e0f095e5ead29ded9).
*  Fixed: Docker environment [#401112e](https://github.com/ouxsoft/PHPMarkup/commit/401112e169c2a585df77e04e633258fdef1ae272).
*  Added: Individual width and height parametrized image requests [#dd86ea7](https://github.com/ouxsoft/PHPMarkup/commit/dd86ea7439be126c0c96ddc3facb935dbd6ad577).
*  Fixed: Image resize algorithm [#dd86ea7](https://github.com/ouxsoft/PHPMarkup/commit/dd86ea7439be126c0c96ddc3facb935dbd6ad577).

## PHPMarkup 1.5.2
Released: 2020-04-19. Notable changes:
*  Added: process=false flag to skip elements [#738565b](https://github.com/hxtree/PHPMarkup/commit/738565b28c8acfcf25b44115b8f9fb003759b01f).
*  Added: Code block module for styling code [#738565b](https://github.com/hxtree/PHPMarkup/commit/738565b28c8acfcf25b44115b8f9fb003759b01f).
*  Fixed: DOMElement Arg removal [85ef96c](https://github.com/ouxsoft/PHPMarkup/commit/85ef96c4aea4c172c04f9e7b5db9ab6c56cdba08).
*  Added: Code styles [#4026dab](https://github.com/ouxsoft/PHPMarkup/commit/84026dab3ee8c3cdfd9d34cf3dcbfa5fc0f94b7de).

## PHPMarkup 1.5.1
Released: 2020-05-15. Notable changes:
*  Added: PNG image resize [#2b7b323](https://github.com/hxtree/PHPMarkup/commit/2b7b323bd882ff0ad5ae9a937d0f8a1449b862a1).
*  Fixed: JPG image resize [#2b7b323](https://github.com/hxtree/PHPMarkup/commit/2b7b323bd882ff0ad5ae9a937d0f8a1449b862a1).
*  Added: Image offset / focal point [#56397ca](https://github.com/hxtree/PHPMarkup/commit/56397ca7546b24291f63487ecb930e01398e66c3).
*  Added: Custom SCSS build [#56397ca](https://github.com/hxtree/PHPMarkup/commit/56397ca7546b24291f63487ecb930e01398e66c3).

## PHPMarkup 1.5.0
Released: 2019-05-11. Notable changes:
*  Added: Separate Core and Custom Modules [#e42fc61](https://github.com/hxtree/PHPMarkup/commit/e42fc61e2773e58e51e2e2da43b29ef2cb2e9b59).
*  Added: Docker build option [#173059f](https://github.com/hxtree/PHPMarkup/commit/173059fbff37430cdd805be0ba06f8fbd8b099b6).
*  Added: Bootstrap and Jquery [#3d5104f](https://github.com/hxtree/PHPMarkup/commit/3d5104f395115c9f5d48ec08e87b1474171e8410).
*  Added: Sass Auto Compiler [#06fe0d3](https://github.com/hxtree/PHPMarkup/commit/06fe0d364545dbac2885c6ea53576e4a55cfc07d).
*  Added: Router [#89679f1](https://github.com/hxtree/PHPMarkup/commit/89679f16f8cbffa90a8f0490adb97cb30edd89e3).
*  Moved: Examples into Public Help [#e42fc61](https://github.com/hxtree/PHPMarkup/commit/e42fc61e2773e58e51e2e2da43b29ef2cb2e9b59).
*  Fixed: PHP Unit Test [#e4826dd](https://github.com/hxtree/PHPMarkup/commit/e4826dd3de6ada117dbe3db5089bf9fc2f2bdd9e).

## PHPMarkup 1.4.1
Released: 2019-03-29. Notable changes:

*  Updated: Started following Semantic Versioning 2 properly [#74724ce](https://github.com/hxtree/PHPMarkup/commit/00c7ad18fe09465c864a6bb5a20618fbd7ce8e83).
