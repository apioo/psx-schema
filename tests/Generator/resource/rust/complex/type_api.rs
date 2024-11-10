use serde::{Serialize, Deserialize};
use type_schema::TypeSchema;
use definition_type::DefinitionType;
use security::Security;
use operation::Operation;

// The TypeAPI Root
#[derive(Serialize, Deserialize)]
pub struct TypeAPI {
    #[serde(rename = "import")]
    import: Option<std::collections::HashMap<String, String>>,

    #[serde(rename = "definitions")]
    definitions: Option<std::collections::HashMap<String, DefinitionType>>,

    #[serde(rename = "root")]
    root: Option<String>,

    #[serde(rename = "baseUrl")]
    base_url: Option<String>,

    #[serde(rename = "security")]
    security: Option<Security>,

    #[serde(rename = "operations")]
    operations: Option<std::collections::HashMap<String, Operation>>,

}

