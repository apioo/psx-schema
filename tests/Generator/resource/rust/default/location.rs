use serde::{Serialize, Deserialize};

// Location of the person
#[derive(Serialize, Deserialize)]
pub struct Location {
    #[serde(rename = "lat")]
    lat: Option<f64>,

    #[serde(rename = "long")]
    long: Option<f64>,

}

