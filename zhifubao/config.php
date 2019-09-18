<?php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "2016092700605813",

    //商户私钥
    'merchant_private_key' => "MIIEpQIBAAKCAQEA1YZYWkKZJTTl9ppOsPOPxXhZBUuup58cwuqHxEbFj5xpsPBMR+upm4uV802xt/wgpELIbGaARfx/Gnxdu/JzCSUNfWUAfLBpWFLNn/jvmIwieFEs9ntL/Gt2s57DVswCqtgyK27uKeqf0bvXhgI7QOJoO2ub18sLcUhrCMgEzWmvJz26DgCWDlqE57GV0tEbseuYwZrCPBjntdg1CZnPA3LhcG/wF36duDH4VXjAMu3+p/Z2OOvqjq4coA+Sb93q4xiYfop3KSbVUg34GVj3IhBG0+qNtHkHPs3GquQK9cDbUhrtL/1hcdyxSdzw/q/jSwnzEhMIRNwgMBOfp/z7KwIDAQABAoIBAQC+Gw+cxQCuxKsd5QK8vw05Jk4zzc8hhCNKUx8vnEcW9o6PL1LrEaF/UEbgSUM6aKrzNFZXVOdN6GGNxj56MIFFGg0poHxPh40zSv2yOSOw8MtbzgI3LU1Y3qDfiTGnnJmfXD9GtkwrW66RQCnCMUhqG2nrxYIKHcgBQxWwysyjyJyAtpbnOm3nB4QqHscDiXF5Q8UgCLA+TLr/PRYw/0z7uaicgR2U0T2HHB9JCIi/LZUVATL9Kr1VFMgIbFb7jdsOFVyBLnwqak1UWeP6M+A+CmFg6b59LWTZy1TOQoSkaxcMPT5CsAph23npvo3Fpy9uV5Fko+9ngSHLjpXeEkLhAoGBAPYT1WO9Zhh1tqVLQbxfCr2cyN1bqJWGKnmkmaR6vSKpb6g/ihbg0EEWni2EPqGkWXFEMkgflhLwfsFV37GmuYa1t/FYNhSl0IWmj96obLRJ1nnchDeXEoYb9x4aJezeOhZlMgBVB3IyWW16sEZdeXybdKZ+jrFJxHaGba5dJ6jbAoGBAN4ie3RopjnvrgZqLxhllGQC3rDMlMLuQKBfk5hIrLpXx+5CDKMWLPnh8AE3RRI+KG2hlV3aqIDAsPtMEC1oWSNlzU77kNUyDwNHMz+/PQ6xKp5Rf6v8OTRY3BQiBn4OwLmDKwPEPu6EDr/4tlc0+ce3E63cg1E7PhcyAJjuhZ/xAoGBAMg6TzG/FOnmLl3FJJHwC79Jaa+kO0KfTsR4CIRrUqZ3k+ElAmmnOA0eKEsFBilkn1qokPlaqjRy99C83S2iaeeQyUFZ83dNjKSTaRFVnk38nsW9ht/szyfMbYFS6XUZRc6fPNZEWbC0A0wvvmsi+A1KONqYs+bSDUgcDfcI2ZJtAoGAf00XnxDSImW/P6Het4aPUflrEbtMjaHom3/qn90WT/w6ccqcX2I4CER5PNkl1lyU4q81YIINCyxiwMFIjB0+6FBRJrB4whVcES7eqeu43BCgMfbWygNT7TH3ffo56kgeHrKTFieDQUGhCldIeBW+B7xdpMe44fankLdxLDOVlKECgYEAvUqIqFFNimPLLFe1Mf+1Egq/Qkz8vRQke0wZYmmnol19TaNHwijhkdFJXlW3v97Rp8v0bkPoojytZIlA6yRGGKDXSUWonn+UmWS0cABt1eGyv+Y+0Nm2Hao2dB89OpAoBJhyTsXylfZ/nkDYWWFwT9LWbPAraovYsMlFzKxJXxo=",

    //异步通知地址
    'notify_url' => "http://localhost/parkingManagerNew/zhifubao/notify_url.php",

    //同步跳转
    'return_url' => "http://localhost/parkingManagerNew/zhifubao/return_url.php",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvL/N1533t6VurzqZcpXYh1j/mEzkqkqU5VyVwMdST0K8/FRFL5O73Djt7+jJ0J87lSIoDe8H1I6vAjx7XOXCqC7lXTg/aa0GWpEN7IbaNcQpKyf+oBDBGaNFyWlBQUOka22N7WbMRDReexGe9NiJSwL3nMPAa8uNw860UspS6egxlPZ/j0SjE+afxRMc75c6Qm9tUnU8JTgYNYmcwww/VVIIjMbjtmr0p2VodeGhSAPmA+AkBzFhkA+/X3dy6w6QTuWXhtsoOPmfogPH+Nv/yd0wZXyzEF8oBABwYAnPtWoI1v9zWSK2GjuaZANklC8C9cp20K9ECpReT3siBh79HQIDAQAB",
);