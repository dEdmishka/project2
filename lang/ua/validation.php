<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute має бути прийняте.',
    'accepted_if' => 'Поле :attribute має бути прийняте, коли :other має значення :value.',
    'active_url' => 'Поле :attribute має бути дійсною URL-адресою.',
    'after' => 'Поле :attribute має бути датою після :date.',
    'after_or_equal' => 'Поле :attribute має бути датою після або рівною :date.',
    'alpha' => 'Поле :attribute має містити лише літери.',
    'alpha_dash' => 'Поле :attribute має містити лише літери, цифри, дефіси та символи підкреслення.',
    'alpha_num' => 'Поле :attribute має містити лише літери та цифри.',
    'array' => 'Поле :attribute має бути масивом.',
    'ascii' => 'Поле :attribute повинно містити лише однобайтові буквено-цифрові символи та символи.',
    'before' => 'Поле :attribute має бути датою, що передує :date.',
    'before_or_equal' => 'Поле :attribute має бути датою, що передує або дорівнює :date.',
    'between' => [
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
        'file' => 'Поле :attribute має бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute має бути від :min до :max.',
        'string' => 'Поле :attribute має містити від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute має бути true або false.',
    'can' => 'Поле :attribute містить неавторизоване значення.',
    'confirmed' => 'Підтвердження поля :attribute не збігається.',
    'contains' => 'У полі :attribute відсутнє обов`язкове значення.',
    'current_password' => 'Пароль неправильний.',
    'date' => 'Поле :attribute має бути дійсною датою.',
    'date_equals' => 'Поле :attribute має бути датою, що дорівнює :date.',
    'date_format' => 'Поле :attribute має відповідати формату :format.',
    'decimal' => 'Поле :attribute повинно мати :decimal знаки після коми.',
    'declined' => 'The Поле :attribute має бути відхилено.',
    'declined_if' => 'Поле :attribute має бути відхилено, коли :other має значення :value.',
    'different' => 'Поле :attribute та :other мають бути різними.',
    'digits' => 'Поле :attribute має бути :digits цифр.',
    'digits_between' => 'Поле :attribute має бути між :min та :max цифрами.',
    'dimensions' => 'Поле :attribute має недійсні розміри зображення.',
    'distinct' => 'Поле :attribute має дублікат значення.',
    'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися одним із наступних: :values.',
    'doesnt_start_with' => 'Поле :attribute не повинно починатися з одним із наступних: :values.',
    'email' => 'Поле :attribute має бути дійсною адресою електронної пошти.',
    'ends_with' => 'Поле :attribute має закінчуватися одним із наступних: :values.',
    'enum' => 'Вибраний :attribute недійсний.',
    'exists' => 'Вибраний :attribute недійсний.',
    'extensions' => 'Поле :attribute має мати одне з наступних розширень: :values.',
    'file' => 'Поле :attribute має бути файлом.',
    'filled' => 'Поле :attribute має мати значення.',
    'gt' => [
        'array' => 'Поле :attribute повинно містити більше елементів :value.',
        'file' => 'Поле :attribute має бути більше за :value кілобайт.',
        'numeric' => 'Поле :attribute має бути більше за :value.',
        'string' => 'Поле :attribute має бути більше за :value символів.',
    ],
    'gte' => [
        'array' => 'Поле :attribute має містити елементи :value або більше.',
        'file' => 'Поле :attribute має бути більше або дорівнювати :value кілобайтам.',
        'numeric' => 'Поле :attribute має бути більше або дорівнювати :value кілобайтам.',
        'numeric' => 'Поле :attribute має бути більше або дорівнювати :value.',
        'string' => 'Поле :attribute має бути більше або дорівнювати :value символів.',
    ],
    'hex_color' => 'Поле :attribute має бути дійсним шістнадцятковим кольором.',
    'image' => 'Поле :attribute має бути зображенням.',
    'in' => 'Вибране :attribute недійсне.',
    'in_array' => 'Поле :attribute має існувати в :other.',
    'integer' => 'Поле :attribute має бути цілим числом.',
    'ip' => 'Поле :attribute має бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute має бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute має бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute має бути дійсним JSON рядок.',
    'list' => 'Поле :attribute має бути списком.',
    'lowercase' => 'Поле :attribute має бути нижнім регістром.',
    'lt' => [
        'array' => 'Поле :attribute має містити менше елементів :value.',
        'file' => 'Поле :attribute має бути менше ніж :value кілобайт.',
        'numeric' => 'Поле :attribute має бути менше ніж :value.',
        'string' => 'Поле :attribute має містити менше ніж :value символів.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не повинно містити більше ніж :value елементів.',
        'file' => 'Поле :attribute має бути менше або дорівнювати :value кілобайт.',
        'numeric' => 'Поле :attribute має бути менше або дорівнює :value.',
        'string' => 'Поле :attribute має бути менше або дорівнює символам :value.',
    ],
    'mac_address' => 'Поле :attribute має бути дійсною MAC-адресою.',
    'max' => [
        'array' => 'Поле :attribute не повинно містити більше :max елементів.',
        'file' => 'Поле :attribute не повинно бути більше :max кілобайт.',
        'numeric' => 'Поле :attribute не повинно бути більше :max.',
        'string' => 'Поле :attribute не повинно бути більше :max символів.',
    ],
    'max_digits' => 'Поле :attribute не повинно містити більше :max цифр.',
    'mimes' => 'Поле :attribute має бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute має бути файлом типу: :values.',
    'min' => [
        'array' => 'Поле :attribute повинно містити щонайменше :min елементів.',
        'file' => 'Поле :attribute повинно містити щонайменше :min кілобайт.',
        'numeric' => 'Поле :attribute повинно містити щонайменше :min.',
        'string' => 'Поле :attribute повинно містити щонайменше :min символів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити щонайменше :min цифр.',
    'missing' => 'Поле :attribute має бути відсутнє.',
    'missing_if' => 'Поле :attribute має бути відсутнє, коли :other дорівнює :value.',
    'missing_unless' => 'Поле :attribute має бути відсутнє, якщо :other дорівнює :value.',
    'missing_with' => 'Поле :attribute має бути відсутнє, якщо присутнє :values.',
    'missing_with_all' => 'Поле :attribute має бути відсутнє, якщо присутнє :values.',
    'multiple_of' => 'Поле :attribute має бути кратним :value.',
    'not_in' => 'Вибраний :attribute недійсний.',
    'not_regex' => 'Формат поля :attribute недійсний.',
    'numeric' => 'Поле :attribute має бути числом.',
    'password' => [
        'letters' => 'Поле :attribute має містити принаймні одну літеру.',

        'mixed' => 'Поле :attribute має містити принаймні одну велику та одну малу літеру.',
        'numbers' => 'Поле :attribute повинно містити принаймні одне число.',
        'symbols' => 'Поле :attribute повинно містити принаймні один символ.',
        'uncompromised' => 'Вказаний :attribute з`явився під час витоку даних. Будь ласка, виберіть інший :attribute.',
    ],
    'present' => 'Поле :attribute має бути присутнім.',
    'present_if' => 'Поле :attribute має бути присутнім, коли :other має бути :value.',
    'present_unless' => 'Поле :attribute має бути присутнім, якщо :other не має значення :value.',
    'present_with' => 'Поле :attribute має бути присутнім, коли присутній :values.',
    'present_with_all' => 'Поле :attribute має бути присутнім, коли присутні :values.',
    'prohibited' => 'Поле :attribute заборонено.',
    'prohibited_if' => 'Поле :attribute заборонено, коли :other має бути :value.',
    'prohibited_if_accepted' => 'Поле :attribute заборонено, коли :other прийнятий.',
    'prohibited_if_declined' => 'Поле :attribute заборонено, коли :other відхилено.',
    'prohibited_unless' => 'Поле :attribute заборонено, якщо :other не знаходиться в :values.',
    'prohibites' => 'Поле :attribute забороняє присутність :other.',
    'regex' => 'Формат поля :attribute недійсний.',
    'required' => 'Поле :attribute обов`язкове.',
    'required_array_keys' => 'Поле :attribute має містити записи для: :values.',
    'required_if' => 'Поле :attribute обов`язкове, коли :other має значення :value.',
    'required_if_accepted' => 'Поле :attribute обов`язкове, коли :other прийнято.',
    'required_if_declined' => 'Поле :attribute обов`язкове, коли :other відхилено.',
    'required_unless' => 'Поле :attribute обов`язкове, якщо :other не входить до :values.',
    'required_with' => 'Поле :attribute обов`язкове, коли присутнє :values.',
    'required_with_all' => 'Поле :attribute обов`язкове, коли присутні :values.',
    'required_without' => 'Поле :attribute обов`язкове, коли :values ​​відсутній.',
    'required_without_all' => 'Поле :attribute обов`язкове, коли жодне з :values ​​відсутній.',
    'same' => 'Поле :attribute має відповідати :other.',
    'size' => [
        'array' => 'Поле :attribute має містити :size елементів.',
        'file' => 'Поле :attribute має бути :size кілобайт.',
        'numeric' => 'Поле :attribute має бути :size.',
        'string' => 'Поле :attribute має бути :size символів.',
    ],
    'starts_with' => 'Поле :attribute має починатися з одного з наступних: :values.',
    'string' => 'Поле :attribute має бути рядком.',
    'timezone' => 'Поле :attribute має бути дійсним часовим поясом.',
    'unique' => 'Поле :attribute вже зайнято.',
    'uploaded' => 'Не вдалося завантажити :attribute.',
    'uppercase' => 'Поле :attribute має бути у верхньому регістрі.',
    'url' => 'Поле :attribute має бути дійсним URL-адресою.',
    'ulid' => 'Поле :attribute має бути дійсним ULID.',
    'uuid' => 'Поле :attribute має бути дійсним UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
