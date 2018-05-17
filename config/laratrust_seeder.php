<?php

return [
    'role_structure' => [
        'super' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'role_user', 'c,r,u,d',
            'profile' => 'r,u',
            'tipo_pessoa' => 'c,r,u,d',
            'abastecimentos' => 'c,r,u,d',
            'atendentes' => 'c,r,u,d',
            'bicos' => 'c,r,u,d',
            'bombas' => 'c,r,u,d',
            'clientes' => 'c,r,u,d',
            'combustiveis' => 'c,r,u,d',
            'departamentos' => 'c,r,u,d',
            'grupo_veiculos' => 'c,r,u,d',
            'marca_veiculos' => 'c,r,u,d',
            'modelo_bombas' => 'c,r,u,d',
            'modelo_veiculos' => 'c,r,u,d',
            'produtos' => 'c,r,u,d',
            'tanques' => 'c,r,u,d',
            'tipo_bombas' => 'c,r,u,d',
            'tipo_pessoas' => 'c,r,u,d',
            'ufs' => 'c,r,u,d',
            'unidades' => 'c,r,u,d',
            /* relatorios */
            'posicao_tanques_grafico' => 'a',
            'media_consumo_veiculos_grafico' => 'a',
            'listagem_clientes' => 'a',
            'listagem_veiculos' => 'a',
            'listagem_tanques' => 'a',
            'relatorio_abastecimentos' => 'a',
            'relatorio_abastecimentos_bico' => 'a',
            'relatorio_media_consumo_modelo' => 'a',
            'importar_abastecimentos' => 'a',
            'exportar_exportar_dados_cadastrais' => 'a'
        ],
        'administrador' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'usuario' => [
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'cadastrar',
        'r' => 'listar',
        'u' => 'editar',
        'd' => 'excluir',
        'a' => 'acesso'
    ]
];
