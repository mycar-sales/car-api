<?php

use Tests\TestCase;
use App\Core\Domain\Entities\BaseEntity;

class BaseEntityTest extends TestCase
{
    public function testEntityCanBeConvertedToArray()
    {
        $entity = new class extends BaseEntity {
            public string $property1 = 'value1';
            public string $property2 = 'value2';
        };

        $expected = [
            'property1' => 'value1',
            'property2' => 'value2',
        ];

        $this->assertEquals($expected, $entity->toArray());
    }

    public function testEntityWithObjectPropertyCanBeConvertedToArray()
    {
        $entity = new class extends BaseEntity {
            public string $property1 = 'value1';
            public $property2;

            public function __construct()
            {
                $this->property2 = new class {
                    public function __toString()
                    {
                        return 'value2';
                    }
                };
            }
        };

        $expected = [
            'property1' => 'value1',
            'property2' => 'value2',
        ];

        $this->assertEquals($expected, $entity->toArray());
    }

    public function testEntityWithObjectPropertyHavingToArrayMethodCanBeConvertedToArray()
    {
        $entity = new class extends BaseEntity {
            public string $property1 = 'value1';
            public $property2;

            public function __construct()
            {
                $this->property2 = new class {
                    public function toArray()
                    {
                        return ['subValue1', 'subValue2'];
                    }

                    public function __toString()
                    {
                        return json_encode($this->toArray());
                    }
                };
            }
        };

        $expected = [
            'property1' => 'value1',
            'property2' => "[\"subValue1\",\"subValue2\"]",
        ];

        $this->assertEquals($expected, $entity->toArray());
    }

    public function testEntityWithNoPropertiesReturnsEmptyArray()
    {
        $entity = new class extends BaseEntity {
        };

        $this->assertEquals([], $entity->toArray());
    }

    public function testEntityWithObjectPropertyPrivate()
    {
        $entity = new class extends BaseEntity {
            private string $property1 = 'value1';
            private $property2;

            public function __construct()
            {
                $this->property2 = new class {
                    public function __toString()
                    {
                        return 'value2';
                    }
                };
            }
        };

        $expected = [];

        $this->assertEquals($expected, $entity->toArray());
    }
}
