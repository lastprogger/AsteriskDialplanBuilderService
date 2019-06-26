<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sip_users');

        DB::raw(
            "create table sip_users
(
  id                int auto_increment primary key,
  company_id         varchar(255) null,
  accountcode       varchar(20)                                                   null,
  disallow          varchar(100)                default 'all'                     null,
  allow             varchar(100)                default 'g729;ilbc;gsm;ulaw;alaw' null,
  allowoverlap      enum ('yes', 'no')          default 'yes'                     null,
  allowsubscribe    enum ('yes', 'no')          default 'yes'                     null,
  allowtransfer     varchar(3)                                                    null,
  amaflags          varchar(13)                                                   null,
  autoframing       varchar(3)                                                    null,
  auth              varchar(40)                                                   null,
  buggymwi          enum ('yes', 'no')          default 'no'                      null,
  callgroup         varchar(10)                                                   null,
  callerid          varchar(80)                                                   null,
  cid_number        varchar(40)                                                   null,
  fullname          varchar(40)                                                   null,
  `call-limit`      int(8)                      default 20                         null,
  callingpres       varchar(80)                                                   null,
  canreinvite       char(6)                     default 'no'                     null,
  context           varchar(80)                                                   null,
  defaultip         varchar(15)                                                   null,
  dtmfmode          varchar(7)                                                    null,
  fromuser          varchar(80)                                                   null,
  fromdomain        varchar(80)                                                   null,
  fullcontact       varchar(80)                                                   null,
  g726nonstandard   enum ('yes', 'no')          default 'no'                      null,
  host              varchar(31)                 default ''                        not null,
  insecure          varchar(20)                                                   null,
  ipaddr            varchar(15)                 default ''                        not null,
  language          char(2)                                                       null,
  lastms            varchar(20)                                                   null,
  mailbox           varchar(50)                                                   null,
  maxcallbitrate    int(8)                      default 4                         null,
  mohsuggest        varchar(80)                                                   null,
  md5secret         varchar(80)                                                   null,
  musiconhold       varchar(100)                                                  null,
  name              varchar(80)                 default ''                        not null,
  nat               varchar(255)                default 'force_rport,comedia'      not null,
  outboundproxy     varchar(80)                                                   null,
  deny              varchar(95)                                                   null,
  permit            varchar(95)                                                   null,
  pickupgroup       varchar(10)                                                   null,
  port              varchar(5)                  default ''                        not null,
  progressinband    enum ('yes', 'no', 'never') default 'no'                      null,
  promiscredir      enum ('yes', 'no')          default 'no'                      null,
  qualify           char(3)                      default 'yes'                                 null,
  regexten          varchar(80)                 default ''                        not null,
  regseconds        int                         default 0                         not null,
  rfc2833compensate enum ('yes', 'no')          default 'no'                      null,
  rtptimeout        char(3)                                                       null,
  rtpholdtimeout    char(3)                                                       null,
  secret            varchar(80)                                                   null,
  sendrpid          enum ('yes', 'no')          default 'yes'                     null,
  setvar            varchar(100)                default ''                        not null,
  subscribecontext  varchar(80)                                                   null,
  subscribemwi      varchar(3)                                                    null,
  t38pt_udptl       enum ('yes', 'no')          default 'no'                      null,
  trustrpid         enum ('yes', 'no')          default 'no'                      null,
  type              varchar(6)                  default 'friend'                  not null,
  useclientcode     enum ('yes', 'no')          default 'no'                      null,
  username          varchar(80)                 default ''                        not null,
  usereqphone       varchar(3)                  default 'no'                      not null,
  videosupport      enum ('yes', 'no')          default 'yes'                     null,
  vmexten           varchar(80)                                                   null,
  callbackextension varchar(255)                                                  null,
  useragent         varchar(255)                                                  null,
  regserver         varchar(255),
  phone_number         varchar(255),
  phone_number_id         varchar(255) null,
  created_at timestamp default now()
  
  constraint name
    unique (name)
);

create index name_2
  on sip_users (name);

"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sip_users');
    }
}
