<?php

return [

    /**
     * Public Key From Flutterwave Dashboard
     *
     */
    'publicKey' => getenv('FLUTTERWAVE_PUBLIC_KEY'),

    /**
     * Secret Key From Paystack Dashboard
     *
     */
    'secretKey' => getenv('FLUTTERWAVE_SECRET_KEY'),

    /**
     * Paystack Payment URL
     *
     */
    'encryptionKey' => getenv('FLUTTERWAVE_ENCRYPTION_KEY'),


];
