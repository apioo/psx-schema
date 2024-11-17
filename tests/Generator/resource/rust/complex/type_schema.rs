use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;

// TypeSchema specification
#[derive(Serialize, Deserialize)]
pub struct TypeSchema {
    #[serde(rename = "definitions")]
    definitions: Option<std::collections::HashMap<String, DefinitionType>>,

    #[serde(rename = "import")]
    import: Option<std::collections::HashMap<String, String>>,

    #[serde(rename = "root")]
    root: Option<String>,

}

