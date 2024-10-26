use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;

#[derive(Serialize, Deserialize)]
pub struct Specification {
    #[serde(rename = "import")]
    import: Option<HashMap<String, String>>,

    #[serde(rename = "definitions")]
    definitions: Option<HashMap<String, DefinitionType>>,

    #[serde(rename = "root")]
    root: Option<String>,

}

