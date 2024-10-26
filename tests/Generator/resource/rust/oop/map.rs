use serde::{Serialize, Deserialize};

#[derive(Serialize, Deserialize)]
pub struct Map {
    #[serde(rename = "totalResults")]
    total_results: Option<u64>,

    #[serde(rename = "parent")]
    parent: Option<P>,

    #[serde(rename = "entries")]
    entries: Option<Vec<T>>,

}

