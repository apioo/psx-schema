use serde::{Serialize, Deserialize};
use string_property_type::StringPropertyType;
use integer_property_type::IntegerPropertyType;
use number_property_type::NumberPropertyType;
use boolean_property_type::BooleanPropertyType;
use property_type::PropertyType;

// Base scalar property type
#[derive(Serialize, Deserialize)]
pub struct ScalarPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

