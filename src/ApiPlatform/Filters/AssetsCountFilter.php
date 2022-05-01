<?php

namespace App\ApiPlatform\Filters;

use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Asset;
use Symfony\Component\PropertyInfo\Type;
use Doctrine\ORM\QueryBuilder;

class AssetsCountFilter extends AbstractContextAwareFilter implements SearchFilterInterface
{

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if ($property === 'order' && isset($value['assets'])) {
            $queryBuilder
                ->addSelect('COUNT(DISTINCT a.id) AS HIDDEN assets_count')
                ->innerJoin('o.assets' , 'a')
                ->groupBy('o')
                ->orderBy("assets_count", $value["assets"]);
        }

    }

    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["AssetCount_$property"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'swagger' => [
                    'description' => 'Count by number of assets.',
                    'name' => 'Products Filter',
                ],
            ];
        }

        return $description;
    }
}