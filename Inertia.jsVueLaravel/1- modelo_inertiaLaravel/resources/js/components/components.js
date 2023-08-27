// Importando Componentes
import headerMap from '@/components/headerComponents.js';
import PagesMap  from '@/components/pagesComponents.js';
import pluginMap from '@/components/pluginsComponents.js';

// constante Map
const ComponentsMap = {
  ...PagesMap,
  ...headerMap,
  ...pluginMap
};

export default ComponentsMap;