let routes = {
    api: {
        album: {
            list: {
                url: '/api/albums',
                method: 'get',
            },
            store: {
                url: '/api/albums',
                method: 'post',
            },
            update: {
                url: '/api/albums/{id}',
                method: 'post',
            },
            destroy: {
                url: '/api/albums/{id}',
                method: 'delete',
            },
            show: {
                url: '/api/albums/{id}',
                method: 'get',
            },
            search: {
                url: '/api/albums/search?search=:search',
                method: 'get',
            }
        },image: {
            store: {
                url: '/api/images',
                method: 'post',
            },
            destroy: {
                url: '/api/images/{id}',
                method: 'delete',
            },
            destroyAll: {
                url: '/api/images',
                method: 'delete',
            }
        }
    }
    ,
    web: {
        album: {
            show: {
                url: '/albums/{id}',
                method: 'get'
            }
        }
    }

}

export default routes
