<?php
namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        foreach($openApi->getPaths()->getPaths() as $key => $path){
            if($path->getGet() && $path->getGet()->getSummary() === 'hidden'){
                $openApi->getPaths()->addPath($key, $path->withoutGet(null));
            }
        }
        
        $schemas = $openApi->getComponents()->getSchemas();
        $schemas['Credentials'] =  new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'jaafer'
                ],
                'email' => [
                    'type' => 'string',
                    'example' => 'jaafer@abdaoui.tn'
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'password'
                ]
            ]
                ]);
        $pathItem = new PathItem(
            post: new Operation(
                tags : ['User'],
                operationId : 'apiLogin',
                summary : 'Create new user.',
                requestBody : new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials'
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => [
                        'description' => 'User connected',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Credentials'
                                ]
                            ]
                        ]
                    ]
                ]
            )
                                );
        $openApi->getPaths()->addPath('/register',$pathItem);
        return $openApi;
    }
}