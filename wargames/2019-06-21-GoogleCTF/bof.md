# 


- * Jump to `00400730`
- * Stack:    * `00475474` (`char*`)
- * NOP: `add 0 0 0` or `\x28\x06\xff\xff`

- Jump to `00400840`

Exploit:

1. Send 256 junk bytes
2. Include some NOPs 
3. Push `00475474` onto the stack.
4. Jump to `00400730`. Or push to stack and `ret`.


```

   004008e8 91 ff      bal     print_file                        undefined print_file()
            11 04
--------------------------------------------------------------------------------------
                    s_flag1_00475474                  XREF[1]: local_flag:00400864(*)  
   00475474 66 6c      ds      "flag1"
            61 67 
            31 00
   0047547a 00         ??      00h
   0047547b 00         ??      00h
                    s_segfault_detected!_***CRASH***  XREF[1]: write_out:004008bc(*)  
   0047547c 73 65      ds      "segfault detected! ***CRASH***"
            67 66 
            61 75 
   0047549b 00         ??      00h
   0047549c 66         ??      66h    f
   0047549d 6c         ??      6Ch    l
   0047549e 61         ??      61h    a
   0047549f 67         ??      67h    g
   004754a0 30         ??      30h    0
   004754a1 00         ??      00h
   004754a2 00         ??      00h
   004754a3 00         ??      00h
   004754a4 41 6e      ds      "An error occurred setting a sig
            20 65 
            72 72 

---------------------------------------------------------------
   0040072c 20 00      _addiu  sp,sp,0x20
            bd 27
                    -- Flow Override: CALL_RETURN (CALL_TERMIN
                    ********************************************
                    *                 FUNCTION                 *
                    ********************************************
                    undefined print_file()
                      assume gp = 0x4a8970
                      assume t9 = 0x400730
         undefined    v0:1      <RETURN>
         undefined4   Stack[-0x local_4                     XREF[1]: 00400740(W)  
         undefined4   Stack[-0x local_8                     XREF[1]: 00400744(W)  
         undefined4   Stack[-0x local_18                    XREF[1]: 0040074c(W)  
                    print_file                        XREF[2]: local_flag:00400874(c), 
                                                               write_out:004008e8(c)  
   00400730 0b 00      lui     gp,0xb
            1c 3c


```