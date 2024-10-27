use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;

// TypeSchema specification
#[derive(Serialize, Deserialize)]
pub struct TypeSchema {
    #[serde(rename = "import")]
    import: Option<HashMap<String, String>>,

    #[serde(rename = "definitions")]
    definitions: Option<HashMap<String, DefinitionType>>,

    #[serde(rename = "root")]
    root: Option<String>,

}

