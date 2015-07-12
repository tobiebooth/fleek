## Fleek

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tobiebooth/fleek/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tobiebooth/fleek/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tobiebooth/fleek/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tobiebooth/fleek/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tobiebooth/fleek/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tobiebooth/fleek/build-status/master)

```php
use Fleek\Domain;
use Fleek\OS;
use Fleek\Disk;

$os = new OS;
$os->type = 'hvm';
$os->boot = null;
$os->arch = 'i386';
$os->machine = 'pc';
$os->bootDevices[] = 'cdrom';
$os->bootDevices[] = 'hd';

$cdrom = new Disk('file', 'cdrom');
$cdrom->source = '/home/user/boot.iso';
$cdrom->target = 'hdc';
$cdrom->readonly = true;

$hda = new Disk('file', 'disk');
$hda->source = '/home/user/vm.img';
$hda->target = 'hda';


$domain = new Domain('qemu');
$domain->name = 'abc';
$domain->uuid = '28344792347923';
$domain->memory = 512;
$domain->currentMemory = 128;
$domain->vcpu = 1;
$domain->os = $os;
$domain->devices[] = $cdrom;
$domain->devices[] = $hda;

echo $domain->toXML();
```
turns into

```XML
<domain type="qemu">
 <name>abc</name>
 <uuid>28344792347923</uuid>
 <memory>512</memory>
 <currentMemory>128</currentMemory>
 <vcpu>1</vcpu>
 <os>
  <type arch="i386" machine="pc">hvm</type>
  <boot dev="cdrom"/>
  <boot dev="hd"/>
 </os>
 <devices>
  <disk type="file" device="cdrom">
   <source file="/home/user/boot.iso"/>
   <target dev="hdc"/>
   <readonly/>
  </disk>
  <disk type="file" device="disk">
   <source file="/home/user/vm.img"/>
   <target dev="hda"/>
  </disk>
 </devices>
</domain>
```