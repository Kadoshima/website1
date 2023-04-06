<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'LAA1480249-jfn036');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'LAA1480249');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'DmelnJbeWE4UiZdz');

/** MySQL のホスト名 */
define('DB_HOST', 'mysql212.phy.lolipop.lan');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'F%;IY5a@9t|yy]t#KbcVkMF]ng+<allzt}x_Mwp2@UCMw}Bu$4/mq27pw0v^8e4y');
define('SECURE_AUTH_KEY', 'XzA}=e:23;|~KgGfEW(?".`3(Z(p2g`T$UK6r6<Tb0y4=jao>M,jS:=!(jWr0r^e');
define('LOGGED_IN_KEY', 'gb(N+,jq%Rfjett1g*h![NqYdkiovNH,8cSm7NdFEafnrdI~sUV7!slZvh5`>929');
define('NONCE_KEY', 'iu+YINga.{+06d6,SS6J#s8IH)_KN}Of;?Ch}&k"%8~W/+sdpalY;10rYo22t-<m');
define('AUTH_SALT', '{K~-#:t6%5MQ!6+j5/"M*yNbs;b;e[(f0<1Y3<q@`~s4d;Hp4B-^X15-ON*USM1$');
define('SECURE_AUTH_SALT', '[6EbV;#WyH$}~|Dc!yf>kMsXLbr{lp9%kcw/sTI@&qI4`kbd>EU5*YJP2fG853K&');
define('LOGGED_IN_SALT', 'r)fj;d44*Q$g%"xWht[i6}S:qD,%]B2uY-en&_oFI#AmxS8,n*rMqUMsR4"{U(Y2');
define('NONCE_SALT', 'HFDCcE2hQWawfG[HoDWXQ?""rzCpQ)M5%!5O/!S08k3wbfU>vy,E/KkR8F}3Nw,8');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp20230322133133_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
