class Loader {

// Show the loader
    static show(id= 'loader') {
        let loader = document.getElementById(id)
        if (loader) {
            loader.style.display = 'flex';
            loader.style.justifyContent = 'center';
            loader.style.alignItems = 'center';
            loader.style.position = 'fixed';
            loader.style.top = '0';
            loader.style.left = '0';
            loader.style.width = '100%';
            loader.style.height = '100%';
            loader.style.backgroundColor = 'rgba(0,0,0,0.95)';
            loader.style.zIndex = '100000';

        }

    }

// Hide the loader
    static hide(id= 'loader') {
        let loader = document.getElementById(id)
        if (loader)
            loader.style.display = 'none';
    }
}

export default Loader;
